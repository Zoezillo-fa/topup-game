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
     * 1. MENAMPILKAN DAFTAR PRODUK
     */
    public function index()
    {
        // Load produk, urutkan berdasarkan Game
        $products = Product::orderBy('game_code')->paginate(20);
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
     * 3. PROSES SYNC DARI DIGIFLAZZ (LOGIC UTAMA)
     */
    public function syncProcess(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'game_code' => 'required',
            'provider_brand' => 'required', // Contoh: "Mobile Legends"
            'profit_type' => 'required|in:percent,flat',
            'profit_value' => 'required|numeric',
        ]);

        // B. Ambil Config & Request ke Digiflazz
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        $sign = md5($username . $key . "pricelist");

        try {
            // Timeout diperpanjang jadi 30 detik karena data Price List besar
            // Ini penting untuk localhost dengan koneksi tidak stabil
            $response = Http::timeout(30)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            $result = $response->json();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal koneksi ke server Digiflazz (Timeout). Cek koneksi internet Anda.');
        }

        // C. Validasi Respon API
        
        // 1. Cek Key Data
        if (!isset($result['data'])) {
            return back()->with('error', 'Gagal mengambil data. Respon API kosong.');
        }

        // 2. Cek Error String (Misal: IP Not Allowed, Username salah)
        if (is_string($result['data'])) {
            return back()->with('error', 'Digiflazz Error: ' . $result['data']);
        }

        // 3. Cek Array Kosong (Rate Limit / Gangguan Sesaat)
        if (is_array($result['data']) && count($result['data']) === 0) {
            return back()->with('error', 'Digiflazz mengembalikan data kosong (0 produk). Server mereka mungkin sedang sibuk atau Anda menekan tombol terlalu cepat. Mohon tunggu 1 menit lalu coba lagi.');
        }

        // D. LOGIKA PENCARIAN PINTAR (SMART SEARCH)
        
        $targetBrand = strtolower(trim($request->provider_brand));
        $allData = collect($result['data']);

        // Tahap 1: Cari yang PERSIS sama (Exact Match)
        $items = $allData->filter(function ($item) use ($targetBrand) {
            return isset($item['brand']) && strtolower(trim($item['brand'])) === $targetBrand;
        });

        // Tahap 2: Jika tidak ketemu, cari yang MIRIP (Contains / Mengandung Kata)
        if ($items->isEmpty()) {
            $items = $allData->filter(function ($item) use ($targetBrand) {
                return isset($item['brand']) && str_contains(strtolower($item['brand']), $targetBrand);
            });
        }

        // E. JIKA MASIH TIDAK KETEMU -> TAMPILKAN SARAN
        if ($items->isEmpty()) {
            // Ambil 20 Brand pertama untuk contoh
            $availableBrands = $allData->pluck('brand')->unique()->take(20)->implode(', ');
            
            // Menggunakan format HTML di pesan error
            return back()->with('error', "Gagal menemukan brand '<b>{$request->provider_brand}</b>'. <br><br> Brand yang tersedia saat ini antara lain: <br> <i>{$availableBrands}</i>... (dan lainnya).");
        }

        // F. PROSES SIMPAN (Looping)
        $count = 0;
        foreach ($items as $item) {
            $modal = $item['price'];
            
            // Skip jika harga 0 (Biasanya produk gangguan/kosong)
            if ($modal <= 0) continue;

            // Hitung Margin
            if ($request->profit_type == 'percent') {
                $jual = $modal + ($modal * $request->profit_value / 100);
            } else {
                $jual = $modal + $request->profit_value;
            }
            $jual = ceil($jual); // Pembulatan ke atas

            // Simpan ke Database
            Product::updateOrCreate(
                [
                    // PENTING: Gunakan 'code' sebagai kunci pencarian agar tidak Error Duplicate Entry
                    'code' => $item['buyer_sku_code'], 
                ],
                [
                    'sku_provider' => $item['buyer_sku_code'],
                    'name' => $item['product_name'],
                    'game_code' => $request->game_code,
                    'cost_price' => $modal,
                    'price' => $jual,
                    'is_active' => $item['buyer_product_status'] && $item['seller_product_status'],
                    
                    // PENTING: Isi category agar tidak Error Field Default Value
                    'category' => $item['category'] ?? 'Games'
                ]
            );
            $count++;
        }

        return redirect()->route('admin.products.index')->with('success', "Sukses! $count produk berhasil disinkronkan dari brand: " . $items->first()['brand']);
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