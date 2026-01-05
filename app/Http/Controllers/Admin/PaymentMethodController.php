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
            'tripay' => Configuration::getBy('gateway_tripay_active') == '1',
            'xendit' => Configuration::getBy('gateway_xendit_active') == '1',
            'midtrans' => Configuration::getBy('gateway_midtrans_active') == '1', // [TAMBAHAN]
        ];

        return view('admin.integration.payment.index', compact('payments', 'gatewayStatus'));
    }

    public function updateGatewayStatus(Request $request)
    {
        Configuration::set('gateway_tripay_active', $request->has('tripay') ? '1' : '0');
        Configuration::set('gateway_xendit_active', $request->has('xendit') ? '1' : '0');
        Configuration::set('gateway_midtrans_active', $request->has('midtrans') ? '1' : '0'); // [TAMBAHAN]

        return back()->with('success', 'Status Payment Gateway berhasil diperbarui!');
    }

    public function syncAuto()
    {
        $tripayActive = Configuration::getBy('gateway_tripay_active') == '1';
        $xenditActive = Configuration::getBy('gateway_xendit_active') == '1';
        $midtransActive = Configuration::getBy('gateway_midtrans_active') == '1'; // [TAMBAHAN]
        
        $message = [];

        // 1. TRIPAY (Sync via API)
        if ($tripayActive) {
            $res = $this->fetchTripayChannels();
            if ($res['success']) {
                $message[] = "Tripay: " . $res['count'] . " metode.";
            } else {
                return back()->with('error', "Tripay Error: " . $res['message']);
            }
        } else {
            $deleted = PaymentMethod::where('provider', 'tripay')->delete();
            $message[] = "Tripay: $deleted dihapus.";
        }

        // 2. MIDTRANS (Sync Manual List) [TAMBAHAN]
        if ($midtransActive) {
            $count = $this->seedMidtransChannels();
            $message[] = "Midtrans: $count metode.";
        } else {
            $deleted = PaymentMethod::where('provider', 'midtrans')->delete();
            $message[] = "Midtrans: $deleted dihapus.";
        }

        // 3. XENDIT (Sync QRIS)
        if ($xenditActive) {
            PaymentMethod::where('provider', 'xendit')->where('code', '!=', 'QRIS')->delete();
            $this->seedXenditQRIS();
            $message[] = "Xendit: QRIS disinkronkan.";
        } else {
            $deleted = PaymentMethod::where('provider', 'xendit')->delete();
            $message[] = "Xendit: $deleted dihapus.";
        }

        return back()->with('success', 'Sync Selesai! ' . implode(' | ', $message));
    }

    // --- HELPER MIDTRANS: DAFTAR METODE POPULER ---
    private function seedMidtransChannels()
    {
        $channels = [
            [
                'code' => 'gopay', 'name' => 'GoPay / GoPay Later', 'type' => 'e_wallet', 
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/gopay.png',
                'flat' => 0, 'percent' => 2.0
            ],
            [
                'code' => 'shopeepay', 'name' => 'ShopeePay / SPayLater', 'type' => 'e_wallet',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/shopeepay.png',
                'flat' => 0, 'percent' => 2.0
            ],
            [
                'code' => 'bca_va', 'name' => 'BCA Virtual Account', 'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/bca.png',
                'flat' => 4000, 'percent' => 0
            ],
            [
                'code' => 'bni_va', 'name' => 'BNI Virtual Account', 'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/bni.png',
                'flat' => 4000, 'percent' => 0
            ],
            [
                'code' => 'bri_va', 'name' => 'BRI Virtual Account', 'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/bri.png',
                'flat' => 4000, 'percent' => 0
            ],
            [
                'code' => 'echannel', 'name' => 'Mandiri Bill Payment', 'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/mandiri.png',
                'flat' => 4000, 'percent' => 0
            ],
            [
                'code' => 'permata_va', 'name' => 'Permata Virtual Account', 'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/permata.png',
                'flat' => 4000, 'percent' => 0
            ],
            [
                'code' => 'indomaret', 'name' => 'Indomaret', 'type' => 'retail',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/indomaret.png',
                'flat' => 2500, 'percent' => 0
            ],
            [
                'code' => 'alfamart', 'name' => 'Alfamart', 'type' => 'retail',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/alfamart.png',
                'flat' => 2500, 'percent' => 0
            ],
        ];

        $count = 0;
        foreach ($channels as $c) {
            PaymentMethod::firstOrCreate(
                ['code' => $c['code'], 'provider' => 'midtrans'],
                [
                    'name' => $c['name'],
                    'type' => $c['type'],
                    'image' => $c['image'],
                    'flat_fee' => $c['flat'],
                    'percent_fee' => $c['percent'],
                    'is_active' => 1
                ]
            );
            $count++;
        }
        return $count;
    }

    // --- HELPER XENDIT ---
    private function seedXenditQRIS()
    {
        $code = 'QRIS_XENDIT'; 
        
        if(!PaymentMethod::where('code', $code)->where('provider', 'xendit')->exists()) {
            PaymentMethod::create([
                'code' => $code,
                'name' => 'QRIS Xendit (Isi Saldo)',
                'provider' => 'xendit',
                'flat_fee' => 0,
                'percent_fee' => 0.7, 
                'image' => 'https://tripay.co.id/images/payment-channel/qris.png', 
                'is_active' => 1,
                'type' => 'e_wallet'
            ]);
        }
    }

    // --- HELPER TRIPAY ---
    private function fetchTripayChannels()
    {
        $apiKey = Configuration::getBy('tripay_api_key');
        $mode   = Configuration::getBy('tripay_mode') ?? 'production';
        $baseUrl = ($mode == 'sandbox') ? 'https://tripay.co.id/api-sandbox' : 'https://tripay.co.id/api';

        if (!$apiKey) return ['success' => false, 'message' => 'API Key belum diisi'];

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])
                            ->get($baseUrl . '/merchant/payment-channel');
            $result = $response->json();

            if (!isset($result['success']) || !$result['success']) {
                return ['success' => false, 'message' => $result['message'] ?? 'Unknown Error'];
            }

            foreach ($result['data'] as $channel) {
                PaymentMethod::updateOrCreate(
                    ['code' => $channel['code']], 
                    [
                        'name' => $channel['name'],
                        'provider' => 'tripay',
                        'flat_fee' => $channel['total_fee']['flat'] ?? 0,
                        'percent_fee' => $channel['total_fee']['percent'] ?? 0,
                        'image' => $channel['icon_url'],
                        'is_active' => $channel['active'] ? 1 : 0,
                        'type' => $this->mapGroupType($channel['group']),
                    ]
                );
            }
            return ['success' => true, 'count' => count($result['data'])];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|unique:payment_methods,code',
            'provider' => 'required|in:tripay,xendit,manual,midtrans', // [TAMBAHAN]
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
            'provider' => 'required|in:tripay,xendit,manual,midtrans', // [TAMBAHAN]
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