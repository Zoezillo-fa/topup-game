<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payments = PaymentMethod::all();
        return view('admin.integration.payment.index', compact('payments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'flat_fee' => 'required|numeric',
            'percent_fee' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $payment = PaymentMethod::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'flat_fee' => $request->flat_fee,
            'percent_fee' => $request->percent_fee,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        // Upload Gambar Baru (Jika ada)
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($payment->image && file_exists(public_path($payment->image))) {
                unlink(public_path($payment->image));
            }

            $file = $request->file('image');
            $filename = $payment->code . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/payment'), $filename);
            $data['image'] = '/images/payment/' . $filename;
        }

        $payment->update($data);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    /**
     * FITUR BARU: Ambil Data Channel & Fee dari Tripay Otomatis
     */
    public function syncTripay()
    {
        // 1. Ambil Konfigurasi Tripay dari Database
        $apiKey = \App\Models\Configuration::getBy('tripay_api_key');
        $mode   = \App\Models\Configuration::getBy('tripay_mode') ?? 'production'; // 'sandbox' atau 'production'

        if (!$apiKey) {
            return back()->with('error', 'API Key Tripay belum diisi di menu Integrasi!');
        }

        // 2. Tentukan URL API (Sandbox atau Production)
        $baseUrl = ($mode == 'sandbox') ? 'https://tripay.co.id/api-sandbox' : 'https://tripay.co.id/api';
        
        try {
            // 3. Request ke Tripay
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->get($baseUrl . '/merchant/payment-channel');

            $result = $response->json();

            // Cek jika Gagal
            if (!isset($result['success']) || $result['success'] !== true) {
                return back()->with('error', 'Gagal koneksi ke Tripay: ' . ($result['message'] ?? 'Unknown Error'));
            }

            // 4. Looping Data Channel
            foreach ($result['data'] as $channel) {
                // Cari data di DB berdasarkan kode (Contoh: QRIS, OVO)
                // Jika ada diupdate, jika tidak ada dibuat baru
                \App\Models\PaymentMethod::updateOrCreate(
                    ['code' => $channel['code']], 
                    [
                        'name' => $channel['name'],
                        // Ambil Total Fee (Flat & Persen) yang dibebankan ke Customer
                        'flat_fee' => $channel['total_fee']['flat'] ?? 0,
                        'percent_fee' => $channel['total_fee']['percent'] ?? 0,
                        'image' => $channel['icon_url'], // Pakai icon dari Tripay langsung
                        'is_active' => $channel['active'] ? 1 : 0, // Ikuti status aktif Tripay
                        'type' => $this->mapGroupType($channel['group']), // Helper untuk grouping (optional)
                    ]
                );
            }

            return back()->with('success', 'Berhasil menyinkronkan ' . count($result['data']) . ' metode pembayaran dari Tripay!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // Helper kecil untuk mengelompokkan tipe pembayaran (Virtual Account / E-Wallet)
    private function mapGroupType($groupName)
    {
        if (str_contains(strtolower($groupName), 'virtual')) return 'virtual_account';
        if (str_contains(strtolower($groupName), 'convenience')) return 'retail';
        return 'e_wallet';
    }
}