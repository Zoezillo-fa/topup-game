<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;     
use App\Models\Configuration;
use App\Models\PaymentMethod;
use App\Models\Transaction; 
use Illuminate\Support\Facades\Http; // Wajib import ini untuk request API
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TopupController extends Controller
{
    /**
     * 1. MENAMPILKAN HALAMAN FORM ORDER
     */
    public function index($slug)
    {
        $game = Game::where('code', $slug)->firstOrFail();
        
        $products = Product::where('game_code', $slug)
                            ->where('is_active', 1)
                            ->orderBy('price', 'asc')
                            ->get();

        // Ambil data pembayaran aktif
        $paymentChannels = PaymentMethod::where('is_active', 1)->get()->groupBy('type');
        
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    /**
     * 2. LOGIKA CEK ID GAME (LIVE API)
     * Menggunakan https://api.isan.eu.org/nickname
     */
    public function checkGameId(Request $request)
    {
        // Validasi Input
        $request->validate([
            'user_id' => 'required',
            'game_code' => 'required' // Pastikan ini berisi slug pendek (ml, ff, aov, dll) dari target_endpoint di DB
        ]);

        $id = $request->user_id;
        $zone = $request->zone_id;
        $code = $request->game_code; // Contoh: 'ml', 'ff'

        // Susun URL API
        // Format: https://api.isan.eu.org/nickname/{code}?id={id}&server={zone}
        $url = "https://api.isan.eu.org/nickname/{$code}?id={$id}";
        
        // Tambahkan server/zone jika ada (Khusus MLBB, LifeAfter, dll)
        if (!empty($zone)) {
            $url .= "&server={$zone}";
        }

        try {
            // Tembak API
            $response = Http::timeout(10)->get($url);
            $data = $response->json();

            // Cek Respons dari API ISAN
            // Biasanya return { "success": true, "name": "NicknamePlayer", ... }
            if (isset($data['success']) && $data['success'] == true && !empty($data['name'])) {
                return response()->json([
                    'status' => 'success',
                    'nick_name' => $data['name'], 
                    'data' => [
                        'user_id' => $id,
                        'zone_id' => $zone
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'ID tidak ditemukan atau server game sedang sibuk.'
                ]);
            }

        } catch (\Exception $e) {
            // Log error jika koneksi gagal
            Log::error("Cek ID Error: " . $e->getMessage());
            
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
        // A. VALIDASI INPUT USER
        $request->validate([
            'user_id' => 'required|string',
            'zone_id' => 'nullable|string',
            'product_code' => 'required|exists:products,code',
            'promo_code' => 'nullable|string|exists:promos,code',
            'payment_method' => 'required',
        ]);

        // B. AMBIL DATA PRODUK LOKAL
        $product = Product::where('code', $request->product_code)->first();
        $basePrice = $product->price;

        // ============================================================
        // 🛡️ LAYER 1: PROTEKSI HARGA REAL-TIME (DIGIFLAZZ)
        // ============================================================
        
        $realTimeCost = $this->checkRealTimePrice($product->sku_provider);

        // Jika Harga Modal Baru > Harga Jual, Tolak.
        if ($realTimeCost !== false && $realTimeCost > $basePrice) {
            $product->update(['cost_price' => $realTimeCost]); // Update modal di DB
            
            Log::warning("TRANSAKSI DITOLAK (Proteksi Harga): Modal $realTimeCost > Jual $basePrice");
            return back()->with('error', 'Mohon maaf, terjadi perubahan harga dari pusat. Silakan refresh halaman.');
        }

        // ============================================================
        // 🎟️ LAYER 2: LOGIKA PROMO
        // ============================================================
        
        $discountAmount = 0;
        $promoCodeUsed = null;

        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();

            if (!$promo->is_active) {
                return back()->with('error', 'Kode promo sudah tidak aktif.');
            }

            if ($promo->type == 'percent') {
                $discountAmount = $basePrice * ($promo->value / 100);
            } else {
                $discountAmount = $promo->value;
            }

            if ($discountAmount > $basePrice) $discountAmount = $basePrice; 
            $promoCodeUsed = $promo->code;
        }

        // ============================================================
        // 💰 LAYER 3: SIMPAN TRANSAKSI
        // ============================================================

        $finalPrice = ceil($basePrice - $discountAmount);
        $invoice = 'INV-' . strtoupper(Str::random(10));
        $nickname = $request->nickname_game ?? '-'; // Ambil nickname dari hidden input form

        $trx = new Transaction();
        $trx->reference = $invoice;
        $trx->user_id_game = $request->user_id;
        $trx->zone_id_game = $request->zone_id;
        $trx->nickname_game = $nickname;
        $trx->product_code = $product->code;
        $trx->product_name = $product->name;
        $trx->amount = $finalPrice;
        $trx->status = 'UNPAID';
        $trx->processing_status = 'PENDING';
        $trx->save();

        // Redirect Sukses
        $msg = "Order Berhasil!<br>Invoice: <b>{$invoice}</b><br>Total: <b>Rp " . number_format($finalPrice) . "</b>";
        return back()->with('success', $msg);
    }

    /**
     * Helper: Cek Harga Modal Real-Time (Digiflazz)
     */
    private function checkRealTimePrice($sku)
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        if (!$username || !$key) return false;

        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(5)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            
            $result = $response->json();

            if (isset($result['data']) && is_array($result['data'])) {
                $item = collect($result['data'])->firstWhere('buyer_sku_code', $sku);
                if ($item) {
                    // Jika gangguan, return harga tinggi agar ditolak
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