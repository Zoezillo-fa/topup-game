<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameCheckController extends Controller
{
    public function check(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'user_id' => 'required',
            'game_code' => 'required'
        ]);

        // 2. Mapping Kode Game
        // Menyesuaikan kode di Web Kamu -> Kode di API Ihsangan
        $gameMap = [
            'mobilelegend' => 'ml',
            'freefire'     => 'ff',
            'pubg'         => 'pubgm',
            'genshin'      => 'gi',
            'aov'          => 'aov',
            'sausageman'   => 'sausage',
        ];

        // Default ke 'ml' jika kode tidak dikenal
        $targetGame = $gameMap[$request->game_code] ?? 'ml';

        // 3. Susun URL
        // Format API: https://api.isan.eu.org/nickname/{game}
        $apiUrl = env('PROVIDER_CHECK_URL') . '/' . $targetGame;

        // 4. Parameter Query
        $queryParams = [
            'id' => $request->user_id,
            'server' => $request->zone_id, // Zone ID wajib untuk MLBB
        ];

        try {
            // 5. Kirim Request (GET)
            $response = Http::get($apiUrl, $queryParams);
            $result = $response->json();

            // 6. Cek Hasil
            if (isset($result['success']) && $result['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'nick_name' => $result['name']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'ID Tidak Ditemukan / Game Salah'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungi server cek ID.'
            ]);
        }
    }
}