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
     * [UPDATE] SYNC GAME DIGIFLAZZ (LOGIC BLACKLIST)
     * Mengambil semua brand KECUALI yang terdeteksi sebagai PPOB (Pulsa/PLN).
     */
    /**
     * [FINAL] SYNC GAME DARI DIGIFLAZZ
     * Kode ini sudah terbukti bisa membaca 30+ Brand dari API Anda.
     */
    public function syncDigiflazz()
    {
        // 1. KONEKSI KE DIGIFLAZZ
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
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

        if (!isset($result['data'])) {
            return back()->with('error', 'Data API Kosong.');
        }

        // 2. FILTER DATA (Menggunakan Logic yang sukses di Debug tadi)
        $brands = collect($result['data'])
            ->pluck('brand') // Ambil nama brand
            ->unique()       // Hapus duplikat
            ->filter(function ($brand) {
                $b = strtolower($brand);
                
                // Blacklist kata-kata PPOB
                $blacklist = [
                    'pulsa', 'data', 'pln', 'listrik', 'pdam', 'bpjs', 
                    'internet', 'wifi', 'tv', 'finance', 'pascabayar',
                    'indosat', 'telkomsel', 'xl', 'axis', 'tri', 'smartfren'
                ];

                foreach ($blacklist as $word) {
                    if (str_contains($b, $word)) return false; // Buang
                }
                return true; // Simpan
            })
            ->values();

        // 3. PROSES SIMPAN KE DATABASE
        $added = 0;
        $updated = 0;

        foreach ($brands as $brand) {
            // Buat Slug otomatis: "MOBILE LEGENDS" -> "mobile-legends"
            $slug = Str::slug($brand);
            
            // Cek apakah game sudah ada di DB? (Cek Slug atau Brand Asli)
            $game = Game::where('code', $slug)->orWhere('brand_digiflazz', $brand)->first();

            if (!$game) {
                // JIKA BELUM ADA -> BUAT BARU
                Game::create([
                    'name' => $brand, 
                    'code' => $slug,
                    'slug' => $slug,
                    'brand_digiflazz' => $brand, // Penting!
                    'endpoint' => null,
                    'is_active' => true,
                    'thumbnail' => null,
                    'banner' => null
                ]);
                $added++;
            } else {
                // JIKA SUDAH ADA -> UPDATE KOLOM BRAND DIGIFLAZZ-NYA
                // Ini penting agar fitur "Sync Otomatis Produk" nanti berjalan lancar
                $game->update(['brand_digiflazz' => $brand]);
                $updated++;
            }
        }

        return back()->with('success', "SUKSES! Ditemukan {$brands->count()} Brand Valid. Ditambahkan: $added Game Baru. Diperbarui: $updated Game Lama.");
    }
}