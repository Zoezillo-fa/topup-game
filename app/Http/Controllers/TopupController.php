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
    /**
     * Menampilkan halaman form order (Frontend).
     */
    public function index($slug)
    {
        // 1. Cari Game berdasarkan Slug
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        // 2. Ambil Produk terkait Game
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        // 3. Ambil Metode Pembayaran Aktif
        $payments = PaymentMethod::where('is_active', 1)->get();

        // 4. Kelompokkan Metode Pembayaran (Grouping)
        $paymentChannels = [
            'e_wallet'        => $payments->where('type', 'e_wallet'),
            'virtual_account' => $payments->where('type', 'virtual_account'),
            'retail'          => $payments->where('type', 'retail'),
            'manual'          => $payments->whereNull('type'), // Untuk Transfer Bank Manual
        ];
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    /**
     * API Check Game ID (Dipanggil via AJAX).
     */
    public function checkGameId(Request $request, ApigamesService $apigames)
    {
        if (!$request->user_id || !$request->game_code) {
            return response()->json(['status' => 'failed', 'message' => 'Data tidak lengkap']);
        }

        // Panggil Service Apigames
        $result = $apigames->checkNickname(
            $request->user_id,
            $request->zone_id,
            $request->game_code
        );

        return response()->json($result);
    }

    /**
     * Proses Checkout / Pembuatan Transaksi.
     */
    public function process(Request $request, DigiflazzService $digiflazz, PaymentGatewayService $paymentGateway)
    {
        // 1. Validasi Input
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|string', 
        ]);

        $product = Product::where('code', $request->product_code)->first();
        
        // 2. Cek Harga (Member VIP vs Guest)
        $basePrice = (Auth::check() && Auth::user()->role == 'vip') ? $product->price_vip : $product->price;

        // 3. Cek Promo / Kode Voucher
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                $discountAmount = ($promo->type == 'percent') ? $basePrice * ($promo->value / 100) : $promo->value;
            }
        }

        // 4. Tentukan Fee & Objek Payment Method
        $adminFee = 0;
        $paymentCode = $request->payment_method;
        $paymentMethodObj = null;

        if ($paymentCode == 'SALDO') {
            $adminFee = 0;
        } else {
            // Cari data Payment Method di Database
            $paymentMethodObj = PaymentMethod::where('code', $paymentCode)->where('is_active', 1)->first();
            
            if (!$paymentMethodObj) {
                return back()->with('error', 'Metode pembayaran tidak valid atau sedang gangguan.');
            }

            // Hitung fee: Flat + Persen
            $adminFee = $paymentMethodObj->flat_fee + ($basePrice * $paymentMethodObj->percent_fee / 100);
        }

        // 5. Hitung Total Akhir (Bulatkan ke atas)
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        
        // 6. Generate Nomor Invoice Unik (TRX-...)
        $reference = 'TRX-' . strtoupper(Str::random(6)) . rand(100,999);
        
        // Gabungkan User ID dan Zone ID untuk disimpan
        $target = $request->user_id . ($request->zone_id ? ' (' . $request->zone_id . ')' : '');


        // ====================================================
        // A. LOGIKA PEMBAYARAN VIA SALDO (INSTANT)
        // ====================================================
        if ($paymentCode == 'SALDO') {
            
            if (!Auth::check()) {
                return back()->with('error', 'Silakan login terlebih dahulu untuk menggunakan Saldo.');
            }

            $user = Auth::user();

            if ($user->balance < $finalPrice) {
                return back()->with('error', 'Saldo akun tidak mencukupi. Sisa saldo: Rp ' . number_format($user->balance));
            }

            // 1. Simpan Transaksi
            $trx = Transaction::create([
                'user_id'           => $user->id,
                'reference'         => $reference,
                'product_code'      => $product->code,
                'target'            => $target,
                'nickname_game'     => $request->nickname_game ?? '-',
                'service'           => 'GAME',
                'service_name'      => $product->name,
                'amount'            => $finalPrice,
                'price'             => $basePrice,
                'payment_method'    => 'SALDO',
                'payment_provider'  => 'balance',
                'status'            => 'PAID',          // LUNAS
                'processing_status' => 'PENDING',       // OTW PROSES
                'note'              => 'Pembayaran via Saldo Akun'
            ]);

            // 2. Kurangi Saldo User
            $user->decrement('balance', $finalPrice);

            // 3. Tembak API Digiflazz
            $digiflazz->processTransaction($trx);

            return redirect()->route('member.transactions')
                             ->with('success', 'Pembayaran Berhasil! Pesanan sedang diproses.');
        }

        // ====================================================
        // B. LOGIKA PEMBAYARAN VIA GATEWAY (MIDTRANS/TRIPAY/XENDIT)
        // ====================================================
        
        // 1. Simpan Transaksi (Status: UNPAID)
        $trx = Transaction::create([
            'user_id'           => Auth::id() ?? null,
            'reference'         => $reference,
            'product_code'      => $product->code,
            'target'            => $target,
            'nickname_game'     => $request->nickname_game ?? '-',
            'service'           => 'GAME',
            'service_name'      => $product->name,
            'amount'            => $finalPrice,
            'price'             => $basePrice,
            'payment_method'    => $paymentMethodObj->code,
            'payment_provider'  => $paymentMethodObj->provider,
            'status'            => 'UNPAID',           // MENUNGGU BAYAR
            'processing_status' => 'PENDING',
            'note'              => 'Menunggu Pembayaran via ' . $paymentMethodObj->name
        ]);

        // 2. Request URL Pembayaran ke Service
        try {
            $result = $paymentGateway->process($trx, $paymentMethodObj);

            if ($result['success'] && isset($result['redirect_url'])) {
                // Redirect User ke Halaman Pembayaran (Midtrans Snap / Tripay Checkout / Invoice)
                return redirect($result['redirect_url']);
            } else {
                return back()->with('error', $result['message'] ?? 'Gagal mendapatkan URL pembayaran.');
            }

        } catch (\Exception $e) {
            // Update Status Jika Gagal
            $trx->update(['status' => 'FAILED', 'note' => 'Error: ' . $e->getMessage()]);
            Log::error('Payment Gateway Error: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan sistem pembayaran: ' . $e->getMessage());
        }
    }
}