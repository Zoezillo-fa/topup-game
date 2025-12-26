<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Configuration; // [Wajib] Import Model Configuration

class DigiflazzService
{
    public function processTransaction(Transaction $transaction)
    {
        // 1. Ambil Kredensial dari Database (sesuai inputan Admin)
        $username = Configuration::getBy('digiflazz_username');
        $apiKey   = Configuration::getBy('digiflazz_key');
        
        // Cek jika konfigurasi belum diisi
        if (empty($username) || empty($apiKey)) {
            Log::error('Digiflazz Error: Kredensial (Username/Key) belum diatur di Admin Panel.');
            return ['success' => false, 'message' => 'Konfigurasi Server belum diatur'];
        }

        // 2. URL Endpoint Digiflazz (Standar)
        // Jika ingin membedakan URL dev/prod, bisa ambil 'digiflazz_mode' dari config juga.
        $url = 'https://api.digiflazz.com/v1/transaction';

        // 3. Buat Signature (md5: username + key + ref_id)
        $sign = md5($username . $apiKey . $transaction->reference);

        // 4. Siapkan Payload
        $payload = [
            'username'          => $username,
            'buyer_sku_code'    => $transaction->product_code, // Kode produk (misal: x5)
            'customer_no'       => $transaction->user_id_game, // ID Player
            'ref_id'            => $transaction->reference,    // No Invoice/Ref Unik
            'sign'              => $sign,
            // 'testing'        => true, // Uncomment jika ingin mode testing tanpa potong saldo (tergantung akun digiflazz)
        ];

        Log::info('Digiflazz Request:', $payload);

        try {
            // 5. Kirim Request
            $response = Http::post($url, $payload);
            $result = $response->json();
            
            Log::info('Digiflazz Response:', $result);

            // 6. Cek & Update Status Transaksi
            if (isset($result['data'])) {
                $statusPenyedia = $result['data']['status']; // Sukses, Pending, Gagal
                $sn = $result['data']['sn'] ?? null;         // Serial Number / Bukti Topup
                $message = $result['data']['message'] ?? ''; // Pesan dari provider

                if ($statusPenyedia == 'Sukses') {
                    $transaction->update([
                        'processing_status' => 'SUCCESS',
                        'sn' => $sn // Simpan SN jika ada kolomnya (opsional)
                    ]);
                } elseif ($statusPenyedia == 'Pending') {
                    $transaction->update(['processing_status' => 'PROCESS']);
                } else {
                    $transaction->update([
                        'processing_status' => 'FAILED',
                        'note' => $message // Simpan alasan gagal (opsional)
                    ]);
                }
            } else {
                // Jika response tidak standar / error dari API
                $transaction->update(['processing_status' => 'FAILED']);
            }
            
            return $result;

        } catch (\Exception $e) {
            Log::error('Digiflazz Connection Error: ' . $e->getMessage());
            // Jangan langsung set FAILED jika koneksi error (bisa jadi timeout tapi sukses di sana),
            // biarkan status tetap dan cek manual atau via cronjob status.
            return ['success' => false, 'message' => 'Gagal terhubung ke provider'];
        }
    }
}