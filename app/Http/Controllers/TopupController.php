<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;     
use App\Models\Configuration;
use App\Models\PaymentMethod;
use App\Models\Transaction; 
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function index($slug)
    {
        // 1. Ambil Game
        $game = Game::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        
        // 2. Ambil Produk
        $products = Product::where('game_code', $game->code) 
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        // 3. Ambil Payment Active
        $payments = PaymentMethod::where('is_active', 1)->get();

        // 4. GROUPING CHANNEL (PENTING)
        // Pastikan kolom 'type' di database payment_methods sudah terisi!
        $paymentChannels = [
            'e_wallet'        => $payments->where('type', 'e_wallet'),
            'virtual_account' => $payments->where('type', 'virtual_account'),
            'retail'          => $payments->where('type', 'retail'),
            'manual'          => $payments->whereNull('type'), // Jaga-jaga jika type kosong
        ];
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    public function checkGameId(Request $request)
    {
        // Validasi input
        if (!$request->user_id || !$request->game_code) {
            return response()->json(['status' => 'failed', 'message' => 'Data tidak lengkap']);
        }

        $id = $request->user_id;
        $zone = $request->zone_id;
        $slug = $request->game_code; 

        // 1. Logika Penentuan Endpoint API (PENTING!)
        // Default pakai slug
        $endpoint = $slug;

        // Cek database apakah ada settingan khusus di kolom 'target_endpoint'
        $game = Game::where('slug', $slug)->orWhere('code', $slug)->first();
        if ($game && !empty($game->target_endpoint)) {
            $endpoint = $game->target_endpoint;
        }

        // 2. Normalisasi Nama Game untuk API Isan
        // API ini butuh "mobile-legends" bukan "mobile-legends-bang-bang"
        if (Str::contains($endpoint, 'mobile-legend')) {
            $endpoint = 'mobile-legends';
        }
        if (Str::contains($endpoint, 'free-fire')) {
            $endpoint = 'free-fire';
        }
        if (Str::contains($endpoint, 'genshin')) {
            $endpoint = 'genshin-impact';
        }

        // 3. Request ke API
        $url = "https://api.isan.eu.org/nickname/{$endpoint}?id={$id}";
        if (!empty($zone)) {
            $url .= "&server={$zone}";
        }

        try {
            $response = Http::timeout(8)->get($url);
            $data = $response->json();

            if (isset($data['success']) && $data['success'] == true && !empty($data['name'])) {
                return response()->json([
                    'status' => 'success',
                    'nick_name' => $data['name'] // Ini yang dibaca Javascript
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'ID Salah / Server Game Sibuk'
                ]);
            }
        } catch (\Exception $e) {
            // Fallback (Bypass) jika API mati, biar user tetap bisa beli
            return response()->json([
                'status' => 'success',
                'nick_name' => 'Player (Skip Check)',
                'is_fallback' => true
            ]);
        }
    }

    public function process(Request $request)
    {
        // Validasi
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required|exists:payment_methods,code',
        ]);

        $product = Product::where('code', $request->product_code)->first();
        $payment = PaymentMethod::where('code', $request->payment_method)->first();

        // Cek Harga (Member/Guest)
        $basePrice = (Auth::check() && $product->price_vip > 0) ? $product->price_vip : $product->price;

        // Cek Diskon
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

        // Buat Transaksi di DB
        $trx = Transaction::create([
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

        // Redirect
        return redirect()->route('order.check', ['invoice' => $invoice])
                         ->with('success', 'Order berhasil dibuat!');
    }
}