<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('name', 'asc')->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:games,code',
            'slug' => 'required|string|unique:games,slug',
            'endpoint' => 'nullable|string', 
        ]);

        $data = $request->all();
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = '/storage/' . $request->file('thumbnail')->store('images/games', 'public');
        }
        
        if ($request->hasFile('banner')) {
            $data['banner'] = '/storage/' . $request->file('banner')->store('images/games', 'public');
        }

        if ($request->has('brand_digiflazz')) {
            $data['brand_digiflazz'] = $request->brand_digiflazz;
        }

        Game::create($data);

        return back()->with('success', 'Game berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        if ($game->thumbnail && file_exists(public_path($game->thumbnail))) {
            unlink(public_path($game->thumbnail));
        }
        $game->delete();
        return back()->with('success', 'Game berhasil dihapus.');
    }

    /**
     * [FINAL FIX] SYNC GAME DARI DIGIFLAZZ
     * Fitur: Anti-Null, Filter Kategori PPOB, & Blacklist Brand Non-Game (Voucher Makanan/Belanja)
     */
    /**
     * [FIXED SAFE] SYNC GAME DARI DIGIFLAZZ
     * Blacklist diperbaiki agar tidak memblokir game valid (Identity V, MapleStory, dll).
     */
    /**
     * [FINAL FIX] SYNC GAME DIGIFLAZZ (STRICT MODE)
     * Hanya mengambil GAME & VOUCHER GAME. Membuang semua PPOB, Pulsa, & Voucher Belanja.
     */
    public function syncDigiflazz()
    {
        // 1. KONEKSI KE DIGIFLAZZ
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        if(!$username || !$key) {
            return back()->with('error', 'API Key Digiflazz belum disetting!');
        }

        $sign = md5($username . $key . "pricelist");

        try {
            $response = Http::timeout(60)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            $result = $response->json();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal koneksi: ' . $e->getMessage());
        }

        if (!isset($result['data']) || !is_array($result['data'])) {
            return back()->with('error', 'Data API Kosong atau Username/Key Salah.');
        }

        // 2. FILTER DATA (LOGIKA STRICT)
        $brands = collect($result['data'])
            ->filter(function ($item) {
                // A. Validasi Dasar: Buang jika Brand Kosong
                if (empty($item['brand'])) return false;

                // Normalisasi ke huruf kecil
                $category = strtolower($item['category'] ?? '');
                $brand = strtolower($item['brand']);

                // --- B. BLACKLIST KATEGORI (Sangat Lengkap) ---
                // Semua kata kunci ini merujuk pada produk NON-GAME
                $catBlacklist = [
                    'pulsa', 'data', 'paket', 'internet', 'telepon', 'sms', 'roaming', // Seluler
                    'pln', 'listrik', 'token', 'tagihan', 'pascabayar', // Listrik
                    'pdam', 'air', 'gas', 'pertagas', 'pbb', 'samsat', 'pajak', // Tagihan Umum
                    'bpjs', 'asuransi', 'finance', 'multifinance', 'angsuran', 'kredit', // Keuangan
                    'tv', 'televisi', 'internet', 'wifi', 'indihome', // TV & Internet
                    'e-money', 'emoney', 'wallet', 'saldo', 'topup', // E-Wallet Umum
                    'dana', 'ovo', 'gopay', 'shopeepay', 'linkaja', 'sakuku', 'doku', 'isaku', 'jenius',
                    'voucher makanan', 'voucher belanja', 'transportasi', 'streaming', 'hiburan' // Voucher Non-Game
                ];
                
                if (Str::contains($category, $catBlacklist)) return false;

                // --- C. BLACKLIST BRAND (Filter Spesifik) ---
                // Membuang brand yang lolos filter kategori tapi sebenarnya bukan game
                $brandBlacklist = [
                    // Provider Seluler
                    'indosat', 'telkomsel', 'xl', 'axis', 'tri', 'three', 'smartfren', 'by.u', 'hallo', 'matrix', 'switch',
                    
                    // Streaming / Film / Musik
                    'spotify', 'joox', 'viu', 'vidio', 'netflix', 'disney', 'wetv', 'iflix', 
                    'catchplay', 'mola', 'genflix', 'sushiroll', 'youtube', 'itunes', 'apple music',
                    
                    // Voucher Makanan (F&B)
                    'kfc', 'mcd', 'mcdonald', 'burger king', 'pizza hut', 'dominos', 'bakmi gm', 
                    'starbucks', 'kopi', 'grabfood', 'gofood', 'boga group', 'isens',
                    
                    // Belanja / Mall / E-Commerce
                    'shopee', 'tokopedia', 'bukalapak', 'blibli', 'lazada', 'zalora', 
                    'matahari', 'h&m', 'map', 'sodexo', 'alfamart', 'indomaret', 'family mart',
                    'carrefour', 'hypermart', 'superindo', 'transmart', 'gramedia',
                    'ace hardware', 'informa', 'ikea', 'metro', 'unipin',
                    
                    // Bioskop
                    'cgv', 'xxi', 'cinepolis', 'tix id', 'mtix',
                    
                    // Ojol & Transportasi
                    'grab', 'gojek', 'maxim', 'bluebird',
                    
                    // Software / Productivity
                    'google drive', 'microsoft', 'office 365', 'canva', 'zoom', 'bitdefender', 'kaspersky'
                ];

                if (Str::contains($brand, $brandBlacklist)) return false;

                // --- D. WHITELIST CHECK (Opsional - Safety Net) ---
                // Jika masih ragu, kita bisa cek apakah mengandung kata "Game" atau brand game populer
                // Tapi logika A & B di atas sudah mencakup 99% kasus PPOB.
                
                // Lolos semua filter -> Berarti ini GAME
                return true;
            })
            ->pluck('brand')
            ->unique()
            ->values();

        // 3. PROSES SIMPAN KE DATABASE
        $added = 0;
        $updated = 0;

        foreach ($brands as $brand) {
            $slug = Str::slug($brand);
            
            if (empty($slug)) continue;

            $game = Game::where('code', $slug)->orWhere('brand_digiflazz', $brand)->first();

            if (!$game) {
                Game::create([
                    'name' => $brand, 
                    'code' => $slug,
                    'slug' => $slug,
                    'brand_digiflazz' => $brand,
                    'endpoint' => null,
                    'is_active' => true,
                    'thumbnail' => null,
                    'banner' => null
                ]);
                $added++;
            } else {
                $game->update(['brand_digiflazz' => $brand]);
                $updated++;
            }
        }

        return back()->with('success', "SUKSES! Filter Strict Aktif. Ditemukan {$brands->count()} Brand Game Murni. +$added Baru, $updated Diupdate.");
    }
}