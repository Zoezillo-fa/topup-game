<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Configuration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payments = PaymentMethod::all();
        
        $gatewayStatus = [
            'tripay'   => Configuration::getBy('gateway_tripay_active') == '1',
            'xendit'   => Configuration::getBy('gateway_xendit_active') == '1',
            'midtrans' => Configuration::getBy('gateway_midtrans_active') == '1',
        ];

        return view('admin.integration.payment.index', compact('payments', 'gatewayStatus'));
    }

    public function updateGatewayStatus(Request $request)
    {
        Configuration::set('gateway_tripay_active', $request->has('tripay') ? '1' : '0');
        Configuration::set('gateway_xendit_active', $request->has('xendit') ? '1' : '0');
        Configuration::set('gateway_midtrans_active', $request->has('midtrans') ? '1' : '0');

        return back()->with('success', 'Status Payment Gateway berhasil diperbarui!');
    }

    // ==========================================
    // LOGIC SYNC OTOMATIS
    // ==========================================
    public function syncAuto()
    {
        $tripayActive   = Configuration::getBy('gateway_tripay_active') == '1';
        $xenditActive   = Configuration::getBy('gateway_xendit_active') == '1';
        $midtransActive = Configuration::getBy('gateway_midtrans_active') == '1';
        
        $message = [];

        // 1. TRIPAY (Prioritas Utama untuk QRIS)
        if ($tripayActive) {
            $res = $this->fetchTripayChannels();
            if ($res['success']) {
                $message[] = "Tripay: " . $res['count'] . " metode.";
            } else {
                return back()->with('error', "Tripay Error: " . $res['message']);
            }
        } else {
            PaymentMethod::where('provider', 'tripay')->delete();
            $message[] = "Tripay: dihapus.";
        }

        // 2. MIDTRANS
        if ($midtransActive) {
            $count = $this->seedMidtransChannels();
            $message[] = "Midtrans: $count metode.";
        } else {
            PaymentMethod::where('provider', 'midtrans')->delete();
            $message[] = "Midtrans: dihapus.";
        }

        // 3. XENDIT (Sekarang Kosong / Hapus QRIS Lama)
        if ($xenditActive) {
            // Kita hapus logika pembuatan QRIS Xendit Manual disini
            // Jika ada metode Xendit lain (Virtual Account dll) biarkan logic sync-nya (jika ada API)
            // Tapi untuk saat ini kita bersihkan sisa QRIS Xendit Manual
            PaymentMethod::where('provider', 'xendit')->where('code', 'QRIS_XENDIT')->delete();
            $message[] = "Xendit: Bersih.";
        } else {
            PaymentMethod::where('provider', 'xendit')->delete();
            $message[] = "Xendit: dihapus.";
        }

        return back()->with('success', 'Sync Selesai! ' . implode(' | ', $message));
    }

    /**
     * TRIPAY CHANNEL SYNC
     * Updated: Memaksa kode 'QRIS', 'QRISC', 'QRIS2' pakai logo lokal qris.jpg
     */
    private function fetchTripayChannels()
    {
        $apiKey = Configuration::getBy('tripay_api_key');
        $mode   = Configuration::getBy('tripay_mode') ?? 'production';
        $baseUrl = ($mode == 'sandbox') ? 'https://tripay.co.id/api-sandbox' : 'https://tripay.co.id/api';

        if (!$apiKey) return ['success' => false, 'message' => 'API Key Tripay belum diisi'];

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->get($baseUrl . '/merchant/payment-channel');
            $result = $response->json();

            if (!isset($result['success']) || !$result['success']) {
                return ['success' => false, 'message' => $result['message'] ?? 'Tripay API Error'];
            }

            foreach ($result['data'] as $channel) {
                // LOGIC CUSTOM LOGO QRIS
                $image = $channel['icon_url'];
                $codeUpper = strtoupper($channel['code']);

                // Jika Tripay mengirim kode QRIS apa saja, paksa pakai logo lokal
                if (in_array($codeUpper, ['QRIS', 'QRISC', 'QRIS2', 'QRIS_SHOPEEPAY'])) {
                    $image = '/images/payment/qris.jpg';
                }

                PaymentMethod::updateOrCreate(
                    ['code' => $channel['code']], 
                    [
                        'name'        => $channel['name'],
                        'provider'    => 'tripay',
                        'flat_fee'    => $channel['total_fee']['flat'] ?? 0,
                        'percent_fee' => $channel['total_fee']['percent'] ?? 0,
                        'image'       => $image, // Gunakan image hasil filter di atas
                        'type'        => $this->mapGroupType($channel['group']),
                    ]
                );
            }
            return ['success' => true, 'count' => count($result['data'])];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * MIDTRANS CHANNEL SYNC
     */
    private function seedMidtransChannels()
    {
        $baseUrl = 'https://docs.midtrans.com/asset/image/payment-list';

        // Whitelist Midtrans (Hapus 'qris' jika Anda ingin HANYA Tripay yang menangani QRIS)
        $whitelist = [
            'gopay',        
            'shopeepay',    
            // 'qris',      <-- SAYA KOMENTAR AGAR QRIS HANYA DARI TRIPAY
            'bca_va', 
            'bni_va', 
            'bri_va', 
            'echannel',     
            'permata_va',
            'cimb_va',
            'indomaret', 
            'alfamart',
        ];

        $localMap = [
            'gopay'       => '/images/payment/GoPay.png',      
            'shopeepay'   => '/images/payment/shopeepay.jpg',  
            'bca_va'      => '/images/payment/bca.jpg',        
            'bni_va'      => '/images/payment/Bni.png',        
            'bri_va'      => '/images/payment/Bri.jpg',        
            'echannel'    => '/images/payment/Mandiri.jpg',    
            'permata_va'  => '/images/payment/Permata.jpg',    
            'cimb_va'     => '/images/payment/Cimb.png',       
            'indomaret'   => '/images/payment/Indomaret.png',  
            'alfamart'    => '/images/payment/Alfamart.png',   
            'akulaku'     => '/images/payment/Akulaku.jpg',    
        ];

        $allChannels = [
            ['code' => 'gopay', 'name' => 'GoPay / GoPay Later', 'type' => 'e_wallet', 'flat' => 0, 'percent' => 2.0],
            ['code' => 'shopeepay', 'name' => 'ShopeePay / SPayLater', 'type' => 'e_wallet', 'flat' => 0, 'percent' => 2.0],
            ['code' => 'qris', 'name' => 'QRIS', 'type' => 'e_wallet', 'flat' => 0, 'percent' => 0.7],
            ['code' => 'bca_va', 'name' => 'BCA Virtual Account', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'bni_va', 'name' => 'BNI Virtual Account', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'bri_va', 'name' => 'BRI Virtual Account', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'echannel', 'name' => 'Mandiri Bill Payment', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'permata_va', 'name' => 'Permata Virtual Account', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'cimb_va', 'name' => 'CIMB Niaga Virtual Account', 'type' => 'virtual_account', 'flat' => 4000, 'percent' => 0],
            ['code' => 'indomaret', 'name' => 'Indomaret', 'type' => 'retail', 'flat' => 2500, 'percent' => 0],
            ['code' => 'alfamart', 'name' => 'Alfamart', 'type' => 'retail', 'flat' => 2500, 'percent' => 0],
            ['code' => 'akulaku', 'name' => 'Akulaku PayLater', 'type' => 'e_wallet', 'flat' => 0, 'percent' => 2.0],
        ];

        $count = 0;
        PaymentMethod::where('provider', 'midtrans')->whereNotIn('code', $whitelist)->delete();

        foreach ($allChannels as $c) {
            if (!in_array($c['code'], $whitelist)) continue;

            $imagePath = $localMap[$c['code']] ?? "$baseUrl/{$c['code']}.png";

            PaymentMethod::updateOrCreate(
                ['code' => $c['code']], 
                [
                    'name'        => $c['name'],
                    'provider'    => 'midtrans',
                    'type'        => $c['type'],
                    'image'       => $imagePath,
                    'flat_fee'    => $c['flat'],
                    'percent_fee' => $c['percent'],
                    'is_active'   => 1 
                ]
            );
            $count++;
        }
        return $count;
    }

    // CRUD Manual
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|unique:payment_methods,code',
            'provider' => 'required|in:tripay,xendit,manual,midtrans',
            'flat_fee' => 'required|numeric|min:0',
            'percent_fee' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => strip_tags($request->name),
            'code' => $request->code,
            'provider' => $request->provider,
            'flat_fee' => $request->flat_fee,
            'percent_fee' => $request->percent_fee,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'type' => 'manual',
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'pay_' . Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/payment'), $filename);
            $data['image'] = '/images/payment/' . $filename;
        }

        PaymentMethod::create($data);
        return back()->with('success', 'Metode pembayaran baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'provider' => 'required|in:tripay,xendit,manual,midtrans',
            'flat_fee' => 'required|numeric|min:0',
            'percent_fee' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $payment = PaymentMethod::findOrFail($id);
        
        $data = [
            'name' => strip_tags($request->name),
            'provider' => $request->provider,
            'flat_fee' => $request->flat_fee,
            'percent_fee' => $request->percent_fee,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('code')) {
            $data['code'] = $request->code;
        }

        if ($request->hasFile('image')) {
            if ($payment->image && file_exists(public_path($payment->image))) {
                @unlink(public_path($payment->image));
            }
            $file = $request->file('image');
            $filename = 'pay_' . Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/payment'), $filename);
            $data['image'] = '/images/payment/' . $filename;
        }

        $payment->update($data);
        return back()->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    private function mapGroupType($groupName)
    {
        if (str_contains(strtolower($groupName), 'virtual')) return 'virtual_account';
        if (str_contains(strtolower($groupName), 'convenience')) return 'retail';
        return 'e_wallet';
    }
}