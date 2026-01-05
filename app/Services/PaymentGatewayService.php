<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\Configuration;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentGatewayService
{
    public function process(Transaction $transaction, PaymentMethod $method)
    {
        // Switch Provider berdasarkan data di database (payment_methods)
        // Pastikan kolom 'provider' di tabel payment_methods isinya: tripay, xendit, atau midtrans (huruf kecil)
        $provider = strtolower($method->provider);

        switch ($provider) {
            case 'tripay':
                return $this->processTripay($transaction, $method);
            case 'xendit':
                return $this->processXendit($transaction, $method);
            case 'midtrans':
                return $this->processMidtrans($transaction, $method);
            case 'manual':
                // Untuk transfer bank manual, langsung arahkan ke invoice
                return ['success' => true, 'redirect_url' => route('order.check', ['invoice' => $transaction->reference])];
            default:
                throw new \Exception("Provider pembayaran '$provider' tidak didukung.");
        }
    }

    // --- 1. TRIPAY ---
    private function processTripay($trx, $method)
    {
        $apiKey       = Configuration::getBy('tripay_api_key');
        $privateKey   = Configuration::getBy('tripay_private_key');
        $merchantCode = Configuration::getBy('tripay_merchant_code');
        $mode         = Configuration::getBy('tripay_mode') ?? 'sandbox'; // sandbox / production
        
        $baseUrl = ($mode == 'production') 
            ? 'https://tripay.co.id/api/transaction/create' 
            : 'https://tripay.co.id/api-sandbox/transaction/create';

        // Validasi data user (Tripay wajib ada nama & email)
        $userName  = $trx->user ? $trx->user->name : 'Guest User';
        $userEmail = $trx->user ? $trx->user->email : 'guest@example.com';
        $userPhone = $trx->user ? $trx->user->phonenumber : ($trx->target ?? '08123456789');

        $data = [
            'method'         => $method->code, // Kode channel: BRIVA, ALFAMART, dll
            'merchant_ref'   => $trx->reference,
            'amount'         => $trx->amount,
            'customer_name'  => $userName,
            'customer_email' => $userEmail,
            'customer_phone' => $userPhone,
            'order_items'    => [
                [
                    'sku'      => $trx->product_code ?? 'TOPUP',
                    'name'     => $trx->service_name ?? 'Topup Game',
                    'price'    => $trx->amount,
                    'quantity' => 1
                ]
            ],
            'expired_time' => (time() + (24 * 60 * 60)), // 24 Jam
            'signature'    => hash_hmac('sha256', $merchantCode . $trx->reference . $trx->amount, $privateKey)
        ];

        $response = Http::withToken($apiKey)->post($baseUrl, $data);
        $res = $response->json();

        if ($response->successful() && $res['success']) {
            return ['success' => true, 'redirect_url' => $res['data']['checkout_url']];
        }

        return ['success' => false, 'message' => 'Tripay Error: ' . ($res['message'] ?? 'Unknown error')];
    }

    // --- 2. XENDIT ---
    private function processXendit($trx, $method)
    {
        $secretKey = Configuration::getBy('xendit_secret_key');
        
        // Buat Invoice Xendit
        $response = Http::withBasicAuth($secretKey, '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id'      => $trx->reference,
                'amount'           => $trx->amount,
                'payer_email'      => $trx->user ? $trx->user->email : 'guest@nomail.com',
                'description'      => 'Order #' . $trx->reference,
                // 'payment_methods' => [$method->code] // Opsional: batasi metode bayar
            ]);

        $res = $response->json();

        if (isset($res['invoice_url'])) {
            return ['success' => true, 'redirect_url' => $res['invoice_url']];
        }

        return ['success' => false, 'message' => 'Xendit Error: ' . ($res['message'] ?? 'Connection Failed')];
    }

    // --- 3. MIDTRANS ---
    private function processMidtrans($trx, $method)
    {
        // Set Config
        Config::$serverKey    = Configuration::getBy('midtrans_server_key');
        Config::$isProduction = (Configuration::getBy('midtrans_mode') == 'production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // Parameter Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $trx->reference,
                'gross_amount' => (int) $trx->amount,
            ],
            'customer_details' => [
                'first_name' => $trx->user ? $trx->user->name : 'Guest',
                'email'      => $trx->user ? $trx->user->email : 'guest@example.com',
                'phone'      => $trx->user ? $trx->user->phonenumber : ($trx->target ?? '08123456789'),
            ],
            'item_details' => [
                [
                    'id'       => $trx->product_code ?? 'ITEM',
                    'price'    => (int) $trx->amount,
                    'quantity' => 1,
                    'name'     => substr($trx->service_name ?? 'Product', 0, 50), // Midtrans max 50 char name
                ]
            ],
            // Jika ingin user langsung diarahkan ke metode spesifik (misal khusus GOPAY)
            // 'enabled_payments' => [$method->code] 
        ];

        try {
            $paymentUrl = Snap::createTransaction($params)->redirect_url;
            return ['success' => true, 'redirect_url' => $paymentUrl];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Midtrans Error: ' . $e->getMessage()];
        }
    }
}