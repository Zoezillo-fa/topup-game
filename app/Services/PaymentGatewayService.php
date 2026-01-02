<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Http;

class PaymentGatewayService
{
    public function process(Transaction $transaction, PaymentMethod $method)
    {
        // 1. Cek Provider yang dipilih di Database
        switch ($method->provider) {
            case 'tripay':
                return $this->processTripay($transaction, $method);
                break;
            
            case 'xendit':
                return $this->processXendit($transaction, $method);
                break;

            case 'manual':
                return ['success' => true, 'redirect_url' => route('order.check', ['invoice' => $transaction->invoice])];
                break;

            default:
                throw new \Exception("Provider pembayaran tidak dikenali.");
        }
    }

    // --- LOGIC TRIPAY (Yang sudah ada) ---
    private function processTripay($trx, $method)
    {
        $apiKey = config('services.tripay.api_key'); // Atau ambil dari DB Configuration
        $privateKey = config('services.tripay.private_key');
        $merchantCode = config('services.tripay.merchant_code');
        
        // ... Request ke Tripay ...
        // Return Checkout URL
    }

    // --- LOGIC XENDIT (Baru) ---
    private function processXendit($trx, $method)
    {
        // Ambil API Key Xendit (Disarankan simpan di DB Configuration)
        $secretKey = \App\Models\Configuration::getBy('xendit_secret_key');
        
        // Contoh Create Invoice Xendit
        $response = Http::withBasicAuth($secretKey, '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $trx->invoice,
                'amount' => $trx->amount,
                'payer_email' => 'user@email.com', // Opsional
                'description' => 'Topup ' . $trx->product_code,
                'payment_methods' => [$method->code] // Contoh: ['BCA']
            ]);

        $res = $response->json();

        // Update Reference Transaksi (Opsional, simpan ID Xendit)
        if(isset($res['id'])) {
             $trx->update(['reference' => $res['id']]);
             return ['success' => true, 'redirect_url' => $res['invoice_url']];
        }

        return ['success' => false, 'message' => 'Gagal koneksi ke Xendit'];
    }
}