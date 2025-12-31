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
    /**
     * 1. MENAMPILKAN HALAMAN FORM ORDER
     */
    public function index($slug)
    {
        // Cari game berdasarkan slug (pastikan di database kolomnya 'slug' atau 'code')
        $game = Game::where('slug', $slug)->firstOrFail();
        
        // Ambil Produk & Urutkan dari HARGA TERKECIL (Ascending)
        $products = Product::where('game_id', $game->id) // Sesuaikan 'game_id' atau 'game_code' dengan struktur DB Anda
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc') // <--- LOGIKA SORTING DISINI
                            ->get();

        // Ambil data pembayaran aktif & Grouping berdasarkan tipe
        $paymentChannels = [];
        $methods = PaymentMethod::where('is_active', 1)->get();
        
        foreach($methods as $method) {
            $paymentChannels[$method->type][] = $method;
        }
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    /**
     * 2. LOGIKA CEK ID GAME (LIVE API)
     */
    public function checkGameId(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'game_code' => 'required' 
        ]);

        $id = $request->user_id;
        $zone = $request->zone_id;
        $code = $request->game_code; 

        // URL API Cek ID (Isan API)
        $url = "https://api.isan.eu.org/nickname/{$code}?id={$id}";
        if (!empty($zone)) {
            $url .= "&server={$zone}";
        }

        try {
            $response = Http::timeout(5)->get($url);
            $data = $response->json();

            if (isset($data['success']) && $data['success'] == true && !empty($data['name'])) {
                return response()->json([
                    'status' => 'success',
                    'nick_name' => $data['name'], 
                    'data' => ['user_id' => $id, 'zone_id' => $zone]
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'ID tidak ditemukan.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Gagal terhubung ke server validasi.'
            ]);
        }
    }

    /**
     * 3. PROSES ORDER (CHECKOUT)
     */
    public function process(Request $request)
    {
        // A. Validasi
        $request->validate([
            'user_id' => 'required|string',
            'product_code' => 'required|exists:products,code',
            'payment_method' => 'required',
        ]);

        // B. Ambil Produk
        $product = Product::where('code', $request->product_code)->first();
        $basePrice = $product->price;

        // C. Proteksi Harga Real-Time (Cek Modal Digiflazz)
        // Jika harga modal di Digiflazz tiba-tiba lebih mahal dari harga jual kita, tolak transaksi.
        $realTimeCost = $this->checkRealTimePrice($product->sku_provider);
        if ($realTimeCost !== false && $realTimeCost > $basePrice) {
            $product->update(['cost_price' => $realTimeCost]); 
            return back()->with('error', 'Terjadi perubahan harga dari pusat. Silakan refresh halaman.');
        }

        // D. Hitung Diskon (Promo)
        $discountAmount = 0;
        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->is_active) {
                if ($promo->type == 'percent') {
                    $discountAmount = $basePrice * ($promo->value / 100);
                } else {
                    $discountAmount = $promo->value;
                }
            }
        }

        // E. Hitung Total & Fee
        $payment = PaymentMethod::where('code', $request->payment_method)->first();
        $adminFee = $payment->admin_fee_flat + ($basePrice * $payment->admin_fee_percent / 100);
        
        $finalPrice = ceil($basePrice - $discountAmount + $adminFee);
        $invoice = 'TRX-' . strtoupper(Str::random(10));
        
        // F. Simpan Transaksi
        $trx = Transaction::create([
            'reference' => $invoice,
            'user_id' => Auth::id() ?? null,
            'game_id' => $product->game_id,
            'product_code' => $product->code,
            'product_name' => $product->name,
            'user_id_game' => $request->user_id,
            'zone_id_game' => $request->zone_id,
            'nickname_game' => $request->nickname_game ?? '-',
            'payment_method' => $payment->code,
            'payment_name' => $payment->name,
            'amount' => $finalPrice,
            'status' => 'UNPAID',
            'processing_status' => 'PENDING',
        ]);

        // Redirect ke halaman Invoice / Pembayaran
        return redirect()->route('order.check', ['invoice' => $invoice])
                         ->with('success', 'Order berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Helper: Cek Harga Modal Real-Time Digiflazz
     */
    private function checkRealTimePrice($sku)
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        if (!$username || !$key || !$sku) return false;

        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(3)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            
            $result = $response->json();

            if (isset($result['data']) && is_array($result['data'])) {
                $item = collect($result['data'])->firstWhere('buyer_sku_code', $sku);
                if ($item) {
                    // Jika produk gangguan di pusat, return harga tinggi agar ditolak
                    if (!$item['buyer_product_status'] || !$item['seller_product_status']) {
                        return 999999999; 
                    }
                    return $item['price'];
                }
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }
}