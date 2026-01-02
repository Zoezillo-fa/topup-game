<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Configuration;

class ApigamesService
{
    /**
     * Cek Nickname Game via Apigames
     */
    public function checkNickname($userId, $zoneId, $gameSlug)
    {
        // 1. Ambil Config
        $merchantId = Configuration::getBy('apigames_merchant');
        $secretKey  = Configuration::getBy('apigames_secret');

        if (empty($merchantId) || empty($secretKey)) {
            return ['status' => 'success', 'nick_name' => 'Player (Guest Mode)', 'is_fallback' => true];
        }

        // 2. Normalisasi Slug
        $targetGame = $this->mapGameSlug($gameSlug);

        // 3. Format ID
        $targetId = $userId;
        if ($targetGame == 'mobilelegend' && !empty($zoneId)) {
            $targetId = $userId . $zoneId; 
        }

        // 4. Signature & Request
        $signature = md5($merchantId . $secretKey);
        $url = "https://v1.apigames.id/merchant/{$merchantId}/cek-username/{$targetGame}";

        try {
            $response = Http::timeout(25)->get($url, [
                'user_id'   => $targetId,
                'signature' => $signature
            ]);
            
            $data = $response->json();

            if (isset($data['status']) && $data['status'] == 1) {
                $nick = $data['data']['username'] ?? $data['data']['username_game'] ?? 'Player Found';
                return ['status' => 'success', 'nick_name' => $nick];
            }

            return ['status' => 'failed', 'message' => $data['error_msg'] ?? 'ID Tidak Ditemukan'];

        } catch (\Exception $e) {
            Log::error("Apigames Error: " . $e->getMessage());
            return ['status' => 'success', 'nick_name' => 'Player (Server Busy)', 'is_fallback' => true];
        }
    }

    /**
     * Helper untuk mengubah slug website ke format Apigames
     */
    private function mapGameSlug($slug)
    {
        if (Str::contains($slug, ['mobile-legend', 'mlbb'])) return 'mobilelegend';
        if (Str::contains($slug, ['free-fire', 'ff'])) return 'freefire';
        if (Str::contains($slug, ['genshin'])) return 'genshin';
        if (Str::contains($slug, ['pubg'])) return 'pubg';
        if (Str::contains($slug, ['higgs', 'domino'])) return 'higgs';
        
        return $slug; // Default return as is
    }
}