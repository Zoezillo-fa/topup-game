<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\Http;

class IntegrationController extends Controller
{
    // --- 1. DIGIFLAZZ ---

    public function digiflazz()
    {
        return view('admin.integration.digiflazz');
    }

    public function updateDigiflazz(Request $request)
    {
        Configuration::set('digiflazz_username', $request->username);
        Configuration::set('digiflazz_key', $request->key);
        Configuration::set('digiflazz_mode', $request->mode); // Simpan Mode
        
        return back()->with('success', 'Konfigurasi Digiflazz disimpan.');
    }

    public function checkDigiflazz()
    {
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');
        
        // Digiflazz URL biasanya sama untuk Prod/Dev, tapi kredensialnya beda.
        // Jika ada URL khusus dev, bisa diatur disini logic if-else nya.
        $url = 'https://api.digiflazz.com/v1/cek-saldo'; 

        $sign = md5($username . $key . "depo");

        try {
            $response = Http::post($url, [
                'cmd' => 'deposit',
                'username' => $username,
                'sign' => $sign
            ]);

            $result = $response->json();

            if (isset($result['data']['deposit'])) {
                $saldo = number_format($result['data']['deposit'], 0, ',', '.');
                $mode = Configuration::getBy('digiflazz_mode');
                return back()->with('connection_success', "TERHUBUNG ($mode)! ✅ Saldo: Rp $saldo");
            } else {
                return back()->with('connection_failed', "GAGAL! ❌ " . ($result['message'] ?? 'Error'));
            }

        } catch (\Exception $e) {
            return back()->with('connection_failed', "ERROR! Server Digiflazz tidak merespon.");
        }
    }


    // --- 2. TRIPAY ---

    public function tripay()
    {
        return view('admin.integration.tripay');
    }

    public function updateTripay(Request $request)
    {
        Configuration::set('tripay_api_key', $request->api_key);
        Configuration::set('tripay_private_key', $request->private_key);
        Configuration::set('tripay_merchant_code', $request->merchant_code);
        Configuration::set('tripay_mode', $request->mode); // Simpan Mode

        return back()->with('success', 'Konfigurasi Tripay disimpan.');
    }

    public function checkTripay()
    {
        $apiKey = Configuration::getBy('tripay_api_key');
        $mode = Configuration::getBy('tripay_mode');

        // LOGIC GANTI URL OTOMATIS
        if ($mode == 'sandbox') {
            $baseUrl = 'https://tripay.co.id/api-sandbox/merchant/';
        } else {
            $baseUrl = 'https://tripay.co.id/api/merchant/';
        }

        try {
            // Cek endpoint payment-channel untuk tes koneksi
            $response = Http::withToken($apiKey)->get($baseUrl . 'payment-channel');
            $result = $response->json();

            if ($result['success'] == true) {
                return back()->with('connection_success', "TERHUBUNG ($mode)! ✅ API Key Valid.");
            } else {
                return back()->with('connection_failed', "GAGAL! ❌ " . ($result['message'] ?? 'API Key Salah'));
            }
        } catch (\Exception $e) {
            return back()->with('connection_failed', "ERROR! Server Tripay tidak merespon.");
        }
    }

    public function apigames()
    {
        // Ambil konfigurasi saat ini dari database
        $merchant = Configuration::getBy('apigames_merchant');
        $secret   = Configuration::getBy('apigames_secret');
        
        return view('admin.integration.apigames', compact('merchant', 'secret'));
    }

    public function updateApigames(Request $request)
    {
        $request->validate([
            'apigames_merchant' => 'required|string',
            'apigames_secret'   => 'required|string',
        ]);

        // Simpan ke database (table configurations)
        Configuration::updateOrCreate(
            ['key' => 'apigames_merchant'],
            ['value' => $request->apigames_merchant]
        );
        
        Configuration::updateOrCreate(
            ['key' => 'apigames_secret'],
            ['value' => $request->apigames_secret]
        );

        return back()->with('success', 'Konfigurasi Apigames berhasil disimpan.');
    }

    public function checkApigames()
    {
        // Ambil credential
        $merchant = Configuration::getBy('apigames_merchant');
        $secret   = Configuration::getBy('apigames_secret');

        if (!$merchant || !$secret) {
            return back()->with('error', 'Harap simpan Merchant ID dan Secret Key terlebih dahulu.');
        }

        // --- PERBAIKAN SIGNATURE & ENDPOINT ---
        
        // 1. Formula Signature Wajib Pakai ":" (Titik Dua)
        // Format: md5(merchant_id:secret_key)
        $signature = md5($merchant . ':' . $secret);
        
        // 2. Endpoint URL: https://v1.apigames.id/merchant/[merchant_id]
        $url = "https://v1.apigames.id/merchant/{$merchant}";

        try {
            // Kirim Signature sebagai Query Parameter
            $response = Http::get($url, [
                'signature' => $signature
            ]);

            $result = $response->json();

            // Cek respon
            if (isset($result['status']) && $result['status'] == 1) {
                $saldo = number_format($result['data']['saldo'] ?? 0, 0, ',', '.');
                return back()->with('success', "Koneksi BERHASIL! Saldo ApiGames Anda: Rp $saldo");
            } else {
                // Tampilkan pesan error asli dari API jika ada
                $msg = $result['message'] ?? $result['error_msg'] ?? 'Signature Invalid / Merchant Tidak Ditemukan';
                return back()->with('error', "Koneksi GAGAL: $msg");
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error Sistem: ' . $e->getMessage());
        }
    }
}