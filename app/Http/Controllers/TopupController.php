<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

// Import Models
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;
use App\Models\PaymentMethod;
use App\Models\Transaction;

// Import Services
use App\Services\ApigamesService;
use App\Services\DigiflazzService;
use App\Services\PaymentGatewayService;

class TopupController extends Controller
{
    public function index($slug)
    {
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        // Ambil metode pembayaran. 
        // Filter 'provider != xendit' opsional, tergantung apakah Xendit khusus deposit atau tidak.
        // Jika Xendit juga boleh untuk beli langsung, hapus where('provider', '!=', 'xendit')
        $payments = PaymentMethod::where('is_active', 1)
                    ->get();

        $paymentChannels = [
            'e_wallet'        => $payments->where('type', 'e_wallet'),
            'virtual_account' => $payments->where('type', 'virtual_account'),
            'retail'          => $payments->where('type', 'retail'),
            'manual'          => $payments->whereNull('type'), // Manual Transfer
        ];
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    public function checkGameId(Request $request, ApigamesService $apigames)
    {
        if (!$request->user_id || !$request->game_code) {
            return response()->json(['status' => 'failed', 'message' => 'Data tidak lengkap']);
        }

        $result = $apigames->checkNickname(
            $request->user_id,
            $request->zone_id,
            $request->game_code
        );

        return response()->json($result);
    }

    public function process(Request $request, DigiflazzService $digiflazz, PaymentGatewayService $paymentGateway)
    {
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|string', 
        ]);

        $product = Product::where('code', $request->product_code)->first();
        
        // 1. Cek Harga (VIP vs Guest)
        // Gunakan price_vip jika user login & role vip, jika tidak gunakan price biasa
        $basePrice = (Auth::check() && Auth::user()->role == 'vip') ? $product->price_vip : $product->price;

        // 2. Cek Promo
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                $discountAmount = ($promo->type == 'percent') ? $basePrice * ($promo->value / 100) : $promo->value;
            }
        }

        // 3. Tentukan Admin Fee & Objek Payment
        $adminFee = 0;
        $paymentCode = $request->payment_method;
        $paymentMethodObj = null;

        if ($paymentCode == 'SALDO') {
            $adminFee = 0;
        } else {
            $paymentMethodObj = PaymentMethod::where('code', $paymentCode)->first();
            
            if (!$paymentMethodObj) {
                return back()->with('error', 'Metode pembayaran tidak valid.');
            }

            // Hitung fee: Flat + Persen
            $adminFee = $paymentMethodObj->flat_fee + ($basePrice * $paymentMethodObj->percent_fee / 100);
        }

        // 4. Hitung Total Akhir
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        
        // 5. Buat Nomor Invoice (TRX-...)
        $reference = 'TRX-' . strtoupper(Str::random(6)) . rand(100,999);

        // Gabungkan User ID dan Zone ID (jika ada) untuk kolom target
        $target = $request->user_id . ($request->zone_id ? ' (' . $request->zone_id . ')' : '');

        // ====================================================
        // A. LOGIKA PEMBAYARAN VIA SALDO (AUTO PROCESS)
        // ====================================================
        if ($paymentCode == 'SALDO') {
            
            if (!Auth::check()) {
                return back()->with('error', 'Silakan login terlebih dahulu untuk menggunakan Saldo.');
            }

            $user = Auth::user();

            if ($user->balance < $finalPrice) {
                return back()->with('error', 'Saldo akun tidak mencukupi. Sisa saldo: Rp ' . number_format($user->balance));
            }

            // 1. Simpan Transaksi (Status: PAID)
            $trx = Transaction::create([
                'user_id'           => $user->id,
                'reference'         => $reference,      // [FIX] Gunakan 'reference' sesuai DB
                'product_code'      => $product->code,
                'target'            => $target,         // [FIX] Simpan ID Game User
                'nickname_game'     => $request->nickname_game ?? '-',
                'service'           => 'GAME',          // Penanda Jenis Transaksi
                'service_name'      => $product->name,
                'amount'            => $finalPrice,
                'price'             => $basePrice,      // Harga dasar produk
                'payment_method'    => 'SALDO',
                'payment_provider'  => 'balance',
                'status'            => 'PAID',          // Langsung Lunas
                'processing_status' => 'PENDING',       // Menunggu diproses Digiflazz
                'note'              => 'Pembayaran via Saldo Akun'
            ]);

            // 2. Kurangi Saldo User
            $user->decrement('balance', $finalPrice);

            // 3. Proses ke Provider (Digiflazz)
            $digiflazz->processTransaction($trx);

            // Redirect ke halaman riwayat transaksi member (karena sudah lunas)
            return redirect()->route('member.transactions')
                             ->with('success', 'Pembayaran Berhasil! Pesanan sedang diproses.');
        }

        // ====================================================
        // B. LOGIKA PEMBAYARAN VIA GATEWAY (TRIPAY/XENDIT)
        // ====================================================
        
        // 1. Simpan Transaksi (Status: UNPAID)
        $trx = Transaction::create([
            'user_id'           => Auth::id() ?? null, // Bisa null jika Guest
            'reference'         => $reference,         // [FIX] Gunakan 'reference'
            'product_code'      => $product->code,
            'target'            => $target,
            'nickname_game'     => $request->nickname_game ?? '-',
            'service'           => 'GAME',
            'service_name'      => $product->name,
            'amount'            => $finalPrice,
            'price'             => $basePrice,
            'payment_method'    => $paymentMethodObj->code,
            'payment_provider'  => $paymentMethodObj->provider,
            'status'            => 'UNPAID',           // Belum Bayar
            'processing_status' => 'PENDING',
            'note'              => 'Menunggu Pembayaran via ' . $paymentMethodObj->name
        ]);

        // 2. Panggil Payment Gateway Service
        try {
            // Service akan mengembalikan array berisi redirect_url (checkout_url)
            $result = $paymentGateway->process($trx, $paymentMethodObj);

            if (isset($result['redirect_url'])) {
                return redirect($result['redirect_url']);
            } else {
                return back()->with('error', 'Gagal mendapatkan URL pembayaran.');
            }

        } catch (\Exception $e) {
            // Jika error, update status jadi FAILED
            $trx->update(['status' => 'FAILED', 'note' => 'Gateway Error: ' . $e->getMessage()]);
            Log::error('Payment Gateway Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}