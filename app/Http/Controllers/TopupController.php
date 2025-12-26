<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Product;
use App\Models\Promo;     // Import Model Promo
use App\Models\Configuration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentMethod;

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

        // TAMBAHAN: Ambil data pembayaran aktif dan kelompokkan berdasarkan Tipe
        $paymentChannels = PaymentMethod::where('is_active', 1)->get()->groupBy('type');
        
        // Kirim variabel $paymentChannels ke view
        return view('topup.index', compact('game', 'products', 'paymentChannels'));
    }

    /**
     * 2. PROSES ORDER (CHECKOUT)
     */
    public function process(Request $request)
    {
        // A. VALIDASI INPUT USER
        $request->validate([
            'user_id' => 'required|string',
            'zone_id' => 'nullable|string',
            'product_code' => 'required|exists:products,code',
            'promo_code' => 'nullable|string|exists:promos,code', // Cek apakah kode ada di tabel promos
        ]);

        // B. AMBIL DATA PRODUK LOKAL
        $product = Product::where('code', $request->product_code)->first();
        $basePrice = $product->price;

        // ============================================================
        // 🛡️ LAYER 1: PROTEKSI HARGA REAL-TIME (ANTI RUGI)
        // ============================================================
        
        // Cek harga modal detik ini ke Digiflazz
        $realTimeCost = $this->checkRealTimePrice($product->sku_provider);

        // Jika gagal koneksi/timeout, kita bisa pilih mau tolak atau lanjut.
        // Di sini kita pilih lanjut tapi kasih warning di log (agar user tidak kecewa).
        // Jika ingin super aman, uncomment baris "return back()" di bawah.
        if ($realTimeCost === false) {
            Log::warning("Gagal cek real-time price untuk SKU: " . $product->sku_provider);
            // return back()->with('error', 'Sistem supplier sibuk. Silakan coba lagi.');
        } 
        else {
            // Jika Harga Modal Baru > Harga Jual Database
            if ($realTimeCost > $basePrice) {
                // Update harga database agar user selanjutnya dapat harga baru
                $product->update(['cost_price' => $realTimeCost]);

                Log::warning("TRANSAKSI DITOLAK (Proteksi Harga): Modal $realTimeCost > Jual $basePrice");
                return back()->with('error', 'Mohon maaf, terjadi perubahan harga dari pusat. Silakan refresh halaman untuk harga terbaru.');
            }
        }

        // ============================================================
        // 🎟️ LAYER 2: LOGIKA PROMO / VOUCHER
        // ============================================================
        
        $discountAmount = 0;
        $promoCodeUsed = null;

        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();

            // 1. Cek Status Aktif
            if (!$promo->is_active) {
                return back()->with('error', 'Kode promo sudah tidak aktif.');
            }

            // 2. Cek Batas Pemakaian (Limit)
            // (Nanti logika ini disempurnakan dengan menghitung jumlah transaksi sukses user)
            // if ($promo->max_usage > 0 && $jumlahTerpakai >= $promo->max_usage) ...

            // 3. Hitung Diskon
            if ($promo->type == 'percent') {
                // Diskon Persen (Misal 10%)
                $discountAmount = $basePrice * ($promo->value / 100);
            } else {
                // Diskon Flat (Misal Rp 5000)
                $discountAmount = $promo->value;
            }

            // Pastikan diskon tidak melebihi harga produk (Masa user dibayar?)
            if ($discountAmount > $basePrice) {
                $discountAmount = $basePrice; // Gratis (Rp 0)
            }

            $promoCodeUsed = $promo->code;
        }

        // ============================================================
        // 💰 LAYER 3: HITUNG TOTAL AKHIR & SIMPAN
        // ============================================================

        $finalPrice = ceil($basePrice - $discountAmount);

        // --- DI SINI ANDA MENYIMPAN KE DATABASE TRANSAKSI ---
        // Karena tabel transaksi belum kita setup lengkap, saya simulasikan hasilnya.
        
        /* $trx = new Transaction();
        $trx->user_id = Auth::id() ?? 0; // Jika ada login
        $trx->game_data = $request->user_id . ($request->zone_id ? " ($request->zone_id)" : "");
        $trx->product_name = $product->name;
        $trx->amount_original = $basePrice;
        $trx->promo_code = $promoCodeUsed;
        $trx->discount = $discountAmount;
        $trx->amount_final = $finalPrice;
        $trx->status = 'PENDING';
        $trx->save();
        
        // Redirect ke Payment Gateway...
        */

        // --- OUTPUT SEMENTARA (UNTUK TESTING) ---
        $msg = "Order Berhasil Dibuat!<br>" .
               "Produk: <b>{$product->name}</b><br>" .
               "Harga Awal: Rp " . number_format($basePrice) . "<br>" .
               "Diskon ($promoCodeUsed): -Rp " . number_format($discountAmount) . "<br>" .
               "-------------------------<br>" .
               "<b>Total Bayar: Rp " . number_format($finalPrice) . "</b>";

        return back()->with('success', $msg);
    }

    /**
     * Helper: Cek Harga Modal Real-Time ke Digiflazz
     * Mengembalikan Harga (Float) atau FALSE jika gagal.
     */
    private function checkRealTimePrice($sku)
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        if (!$username || !$key) return false;

        $sign = md5($username . $key . "pricelist");

        try {
            // Timeout 5-10 detik cukup untuk cek harga
            $response = Http::timeout(8)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            
            $result = $response->json();

            if (isset($result['data']) && is_array($result['data'])) {
                // Cari item yang SKU-nya cocok
                $item = collect($result['data'])->firstWhere('buyer_sku_code', $sku);

                if ($item) {
                    // Cek apakah produk sedang gangguan?
                    if (!$item['buyer_product_status'] || !$item['seller_product_status']) {
                        return 999999999; // Return harga mustahil agar ditolak
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