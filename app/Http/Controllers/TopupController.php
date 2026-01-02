<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import Models
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;
use App\Models\PaymentMethod;
use App\Models\Transaction;

// Import Services
use App\Services\ApigamesService;
use App\Services\DigiflazzService;
use App\Services\PaymentGatewayService; // [BARU] Import Service Gateway

class TopupController extends Controller
{
    public function index($slug)
    {
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        $payments = PaymentMethod::where('is_active', 1)
                    ->where('provider', '!=', 'xendit') // <--- Filter ini kuncinya
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

    // [UPDATE] Inject PaymentGatewayService di sini
    public function process(Request $request, DigiflazzService $digiflazz, PaymentGatewayService $paymentGateway)
    {
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|string', 
        ]);

        $product = Product::where('code', $request->product_code)->first();
        
        // 1. Cek Harga (VIP vs Guest)
        $basePrice = (Auth::check() && $product->price_vip > 0) ? $product->price_vip : $product->price;

        // 2. Cek Promo
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                $discountAmount = ($promo->type == 'percent') ? $basePrice * ($promo->value / 100) : $promo->value;
            }
        }

        // 3. Tentukan Admin Fee & Nama Payment
        $adminFee = 0;
        $paymentCode = $request->payment_method;
        $paymentMethodObj = null; // Variabel untuk menyimpan object PaymentMethod

        if ($paymentCode == 'SALDO') {
            $adminFee = 0;
        } else {
            // Ambil data payment dari DB untuk hitung fee
            $paymentMethodObj = PaymentMethod::where('code', $paymentCode)->first();
            
            if (!$paymentMethodObj) {
                return back()->with('error', 'Metode pembayaran tidak valid.');
            }

            $adminFee = $paymentMethodObj->flat_fee + ($basePrice * $paymentMethodObj->percent_fee / 100);
        }

        // 4. Hitung Total Akhir
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        $invoice = 'TRX-' . strtoupper(Str::random(6)) . rand(100,999);

        // ====================================================
        // LOGIKA PEMBAYARAN VIA SALDO (AUTO PROCESS)
        // ====================================================
        if ($paymentCode == 'SALDO') {
            
            if (!Auth::check()) {
                return back()->with('error', 'Silakan login terlebih dahulu untuk menggunakan Saldo.');
            }

            $user = Auth::user();

            if ($user->balance < $finalPrice) {
                return back()->with('error', 'Saldo akun tidak mencukupi. Sisa saldo: Rp ' . number_format($user->balance));
            }

            // A. Kurangi Saldo User
            $user->decrement('balance', $finalPrice);

            // B. Buat Transaksi (Status: PAID)
            $transaction = Transaction::create([
                'invoice' => $invoice,
                'user_id' => $user->id,
                'game_code' => $product->game_code ?? 'GAME',
                'product_code' => $product->code,
                'target_id' => $request->user_id,
                'zone_id' => $request->zone_id,
                'nickname' => $request->nickname_game ?? '-',
                'amount' => $finalPrice,
                'payment_method' => 'SALDO',
                'status' => 'PAID', // Langsung Lunas
                'note' => 'Pembayaran via Saldo Akun'
            ]);

            // C. Proses ke Provider (Digiflazz)
            $digiflazz->processTransaction($transaction);

            return redirect()->route('order.check', ['invoice' => $invoice])
                             ->with('success', 'Pembayaran Berhasil! Transaksi sedang diproses.');
        }

        // ====================================================
        // LOGIKA PEMBAYARAN VIA GATEWAY / MANUAL (UNPAID)
        // ====================================================
        
        $transaction = Transaction::create([
            'invoice' => $invoice,
            'user_id' => Auth::id() ?? null,
            'game_code' => $product->game_code ?? 'GAME',
            'product_code' => $product->code,
            'target_id' => $request->user_id,
            'zone_id' => $request->zone_id,
            'nickname' => $request->nickname_game ?? '-',
            'amount' => $finalPrice,
            'payment_method' => $paymentCode,
            'status' => 'UNPAID',
            'note' => 'Menunggu Pembayaran'
        ]);

        // [BARU] Panggil Payment Gateway Service Dinamis
        try {
            // Kita kirim objek transaksi & objek payment method ke service
            $result = $paymentGateway->process($transaction, $paymentMethodObj);

            // Jika service mengembalikan URL redirect (Tripay/Xendit)
            if (isset($result['redirect_url'])) {
                return redirect($result['redirect_url']);
            }

        } catch (\Exception $e) {
            // Jika terjadi error saat request ke gateway
            $transaction->update(['status' => 'FAILED', 'note' => 'Gateway Error: ' . $e->getMessage()]);
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }

        // Default: Redirect ke halaman cek order (untuk Manual Transfer)
        return redirect()->route('order.check', ['invoice' => $invoice])
                         ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');
    }
}