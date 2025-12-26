<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class DigiflazzService
{
    public function processTransaction(Transaction $transaction)
    {
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.key');
        $baseUrl = config('services.digiflazz.base_url');

        $sign = md5($username . $apiKey . $transaction->reference);

        $payload = [
            'username' => $username,
            'buyer_sku_code' => $transaction->product_code,
            'customer_no' => $transaction->user_id_game,
            'ref_id' => $transaction->reference,
            'sign' => $sign,
        ];

        Log::info('Digiflazz Request:', $payload);

        try {
            $response = Http::post($baseUrl . '/transaction', $payload);
            $result = $response->json();
            
            Log::info('Digiflazz Response:', $result);

            if (isset($result['data'])) {
                $statusPenyedia = $result['data']['status']; 
                if ($statusPenyedia == 'Sukses') {
                    $transaction->update(['processing_status' => 'SUCCESS']);
                } elseif ($statusPenyedia == 'Pending') {
                    $transaction->update(['processing_status' => 'PROCESS']);
                } else {
                    $transaction->update(['processing_status' => 'FAILED']);
                }
            } else {
                $transaction->update(['processing_status' => 'FAILED']);
            }
            return $result;

        } catch (\Exception $e) {
            Log::error('Digiflazz Error: ' . $e->getMessage());
            return ['success' => false];
        }
    }
}