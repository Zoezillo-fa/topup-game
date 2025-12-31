<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Game;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * 1. MENAMPILKAN DAFTAR PRODUK (DENGAN SORTING HARGA)
     */
    public function index()
    {
        // Urutkan berdasarkan Game (A-Z) lalu berdasarkan Harga (Termurah -> Termahal)
        $products = Product::orderBy('game_code', 'asc')
                            ->orderBy('price', 'asc')
                            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * 2. HALAMAN VIEW SYNC (FORM)
     */
    public function syncView()
    {
        $games = Game::all();
        return view('admin.products.sync', compact('games'));
    }

    /**
     * 3. PROSES SYNC DARI DIGIFLAZZ (LOGIC UTAMA + HARGA VIP)
     */
    public function syncProcess(Request $request)
    {
        // A. Validasi Input (Tambahkan validasi untuk VIP)
        $request->validate([
            'game_code' => 'required',
            'provider_brand' => 'required',
            
            // Margin Member Biasa
            'profit_type' => 'required|in:percent,flat',
            'profit_value' => 'required|numeric',

            // Margin Member VIP [BARU]
            'vip_profit_type' => 'required|in:percent,flat',
            'vip_profit_value' => 'required|numeric',
        ]);

        // B. Ambil Config & Request ke Digiflazz
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(30)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid', 'username' => $username, 'sign' => $sign
            ]);
            $result = $response->json();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal koneksi ke Digiflazz (Timeout).');
        }

        if (!isset($result['data']) || !is_array($result['data'])) {
            return back()->with('error', 'Gagal mengambil data dari provider.');
        }

        // C. Filter Data Sesuai Brand
        $targetBrand = strtolower(trim($request->provider_brand));
        $allData = collect($result['data']);

        $items = $allData->filter(function ($item) use ($targetBrand) {
            return isset($item['brand']) && str_contains(strtolower($item['brand']), $targetBrand);
        });

        if ($items->isEmpty()) {
            return back()->with('error', "Brand '$targetBrand' tidak ditemukan.");
        }

        // D. PROSES PERHITUNGAN & SIMPAN
        $count = 0;
        foreach ($items as $item) {
            $modal = $item['price'];
            if ($modal <= 0) continue; // Skip produk gangguan

            // --- 1. HITUNG HARGA MEMBER BIASA ---
            if ($request->profit_type == 'percent') {
                $margin = $modal * ($request->profit_value / 100);
            } else {
                $margin = $request->profit_value;
            }
            $jual = ceil($modal + $margin);

            // --- 2. HITUNG HARGA MEMBER VIP [LOGIKA BARU] ---
            // Menggunakan input dari form, bukan otomatis 70% lagi
            if ($request->vip_profit_type == 'percent') {
                $marginVip = $modal * ($request->vip_profit_value / 100);
            } else {
                $marginVip = $request->vip_profit_value;
            }
            $jualVip = ceil($modal + $marginVip);

            // Pastikan Harga VIP tidak lebih mahal dari Member Biasa (Opsional, safety logic)
            if ($jualVip > $jual) $jualVip = $jual;


            // --- 3. SIMPAN KE DATABASE ---
            Product::updateOrCreate(
                ['code' => $item['buyer_sku_code']], 
                [
                    'sku_provider' => $item['buyer_sku_code'],
                    'name' => $item['product_name'],
                    'game_code' => $request->game_code,
                    'cost_price' => $modal,
                    
                    'price' => $jual,          // Harga Member Biasa
                    'price_vip' => $jualVip,   // Harga VIP
                    
                    'is_active' => $item['buyer_product_status'] && $item['seller_product_status'],
                    'category' => $item['category'] ?? 'Games'
                ]
            );
            $count++;
        }

        return redirect()->route('admin.products.index')->with('success', "Sukses! $count produk diupdate. Harga Member & VIP berhasil diatur.");
    }

    /**
     * [BARU] SYNC SEMUA GAME SEKALIGUS
     */
    public function syncAllProcess(Request $request)
    {
        // 1. Validasi Input Margin Saja (Tidak butuh game_code/brand spesifik)
        $request->validate([
            'profit_type' => 'required|in:percent,flat',
            'profit_value' => 'required|numeric',
            'vip_profit_type' => 'required|in:percent,flat',
            'vip_profit_value' => 'required|numeric',
        ]);

        // 2. Set Time Limit Unlimited (Karena prosesnya lama)
        set_time_limit(300); // 5 Menit

        // 3. Ambil Data Digiflazz
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(60)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid', 'username' => $username, 'sign' => $sign
            ]);
            $result = $response->json();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal koneksi ke Digiflazz.');
        }

        if (!isset($result['data'])) return back()->with('error', 'Data API Kosong.');

        // 4. Ambil Semua Game Lokal Kita
        $localGames = Game::all(); 
        $allDataDigi = collect($result['data']);
        $totalUpdated = 0;

        // 5. Looping Setiap Game Lokal
        foreach ($localGames as $game) {
            
            // LOGIKA BARU:
            // Cek apakah admin sudah setting brand khusus untuk Digiflazz?
            if (!empty($game->brand_digiflazz)) {
                // Jika ada, pakai settingan manual (LEBIH AKURAT)
                $targetBrand = strtolower($game->brand_digiflazz);
            } else {
                // Jika kosong, pakai nama game biasa (AUTO)
                $targetBrand = strtolower($game->name);
            }

            // Filter data Digiflazz yang cocok
            $items = $allDataDigi->filter(function ($item) use ($targetBrand) {
                return isset($item['brand']) && str_contains(strtolower($item['brand']), $targetBrand);
            });

            // Jika ada produk yang cocok, proses simpan
            foreach ($items as $item) {
                $modal = $item['price'];
                if ($modal <= 0) continue;

                // Hitung Margin Member
                if ($request->profit_type == 'percent') {
                    $margin = $modal * ($request->profit_value / 100);
                } else {
                    $margin = $request->profit_value;
                }
                $jual = ceil($modal + $margin);

                // Hitung Margin VIP
                if ($request->vip_profit_type == 'percent') {
                    $marginVip = $modal * ($request->vip_profit_value / 100);
                } else {
                    $marginVip = $request->vip_profit_value;
                }
                $jualVip = ceil($modal + $marginVip);
                if ($jualVip > $jual) $jualVip = $jual;

                // Simpan
                Product::updateOrCreate(
                    ['code' => $item['buyer_sku_code']], 
                    [
                        'sku_provider' => $item['buyer_sku_code'],
                        'name' => $item['product_name'],
                        'game_code' => $game->code, // Pakai kode game yang sedang di-loop
                        'cost_price' => $modal,
                        'price' => $jual,
                        'price_vip' => $jualVip,
                        'is_active' => $item['buyer_product_status'] && $item['seller_product_status'],
                        'category' => $item['category'] ?? 'Games'
                    ]
                );
                $totalUpdated++;
            }
        }

        return redirect()->route('admin.products.index')->with('success', "Proses Selesai! Total $totalUpdated produk berhasil disinkronkan ke berbagai game.");
    }

    /**
     * [BARU] AJAX: Ambil Daftar Brand Unik dari Digiflazz
     */
    public function getDigiflazzBrands()
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        $sign = md5($username . $key . "pricelist");

        try {
            // Cache selama 60 menit agar tidak membebani server/API
            $brands = \Illuminate\Support\Facades\Cache::remember('digi_brands_list', 3600, function () use ($username, $sign) {
                
                $response = Http::timeout(30)->post('https://api.digiflazz.com/v1/price-list', [
                    'cmd' => 'prepaid', 'username' => $username, 'sign' => $sign
                ]);
                $result = $response->json();

                if (!isset($result['data'])) return [];

                // Ambil kolom 'brand', hilangkan duplikat, dan urutkan A-Z
                return collect($result['data'])
                        ->pluck('brand')
                        ->unique()
                        ->sort()
                        ->values()
                        ->all();
            });

            return response()->json([
                'status' => 'success',
                'data' => $brands
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * 4. HAPUS PRODUK
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}