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
}