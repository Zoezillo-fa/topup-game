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

// Import Service Baru
use App\Services\ApigamesService;

class TopupController extends Controller
{
    public function index($slug)
    {
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        $payments = PaymentMethod::where('is_active', 1)->get();

        $paymentChannels = [
            'e_wallet'        => $payments->where('type', 'e_wallet'),
            'virtual_account' => $payments->where('type', 'virtual_account'),
            'retail'          => $payments->where('type', 'retail'),
            'manual'          => $payments->whereNull('type'),
        ];
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    // Inject Service langsung di parameter fungsi
    public function checkGameId(Request $request, ApigamesService $apigames)
    {
        // 1. Validasi Input
        if (!$request->user_id || !$request->game_code) {
            return response()->json(['status' => 'failed', 'message' => 'Data tidak lengkap']);
        }

        // 2. Panggil Logic Cek ID dari Service
        // Controller jadi bersih, hanya terima request dan kembalikan response
        $result = $apigames->checkNickname(
            $request->user_id,
            $request->zone_id,
            $request->game_code
        );

        return response()->json($result);
    }

    public function process(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|exists:payment_methods,code',
        ]);

        $product = Product::where('code', $request->product_code)->first();
        $payment = PaymentMethod::where('code', $request->payment_method)->first();

        // Cek Harga VIP/Guest
        $basePrice = (Auth::check() && $product->price_vip > 0) ? $product->price_vip : $product->price;

        // Cek Promo
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                $discountAmount = ($promo->type == 'percent') ? $basePrice * ($promo->value / 100) : $promo->value;
            }
        }

        // Hitung Total
        $adminFee = $payment->flat_fee + ($basePrice * $payment->percent_fee / 100);
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        
        $invoice = 'TRX-' . strtoupper(Str::random(6)) . rand(100,999);

        // Simpan Transaksi
        Transaction::create([
            'invoice' => $invoice,
            'user_id' => Auth::id() ?? null,
            'game_code' => $product->game_code ?? 'GAME',
            'product_code' => $product->code,
            'target_id' => $request->user_id,
            'zone_id' => $request->zone_id,
            'nickname' => $request->nickname_game ?? '-',
            'amount' => $finalPrice,
            'payment_method' => $payment->code,
            'status' => 'Unpaid',
            'note' => 'Menunggu Pembayaran'
        ]);

        return redirect()->route('order.check', ['invoice' => $invoice])
                         ->with('success', 'Order berhasil dibuat!');
    }
}