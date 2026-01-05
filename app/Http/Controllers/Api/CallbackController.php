<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Configuration; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Services\DigiflazzService;
use Illuminate\Support\Facades\DB;

class CallbackController extends Controller
{
    // ==========================================
    // 1. HANDLER CALLBACK TRIPAY
    // ==========================================
    public function handleTripay(Request $request, DigiflazzService $digiflazz)
    {
        // 1. Ambil Signature dari Header
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        
        // 2. Validasi Signature (Keamanan)
        // Pastikan 'tripay_private_key' ada di tabel configurations
        $privateKey = Configuration::getBy('tripay_private_key'); 
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== $callbackSignature) {
            return Response::json(['success' => false, 'message' => 'Invalid Signature'], 400);
        }

        $data = json_decode($json);
        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if ($event == 'payment_status') {
            // Cari transaksi berdasarkan Merchant Ref
            $trx = Transaction::where('reference', $data->merchant_ref)->first();

            if ($trx) {
                // A. JIKA STATUS DIBAYAR (PAID)
                if ($data->status == 'PAID') {
                    if ($trx->status == 'UNPAID') {
                        $this->processSuccess($trx, $digiflazz, "Tripay");
                    }
                } 
                // B. JIKA GAGAL / EXPIRED
                elseif (in_array($data->status, ['EXPIRED', 'FAILED', 'REFUND'])) {
                    $trx->update([
                        'status' => strtoupper($data->status),
                        'processing_status' => 'FAILED'
                    ]);
                }
            }
        }

        return Response::json(['success' => true]);
    }

    // ==========================================
    // 2. HANDLER CALLBACK XENDIT
    // ==========================================
    public function handleXendit(Request $request, DigiflazzService $digiflazz)
    {
        // 1. Validasi Token Xendit
        $xenditTokenHeader = $request->header('x-callback-token');
        $myToken = Configuration::getBy('xendit_callback_token');

        // Jika token di database diisi, maka wajib sama
        if ($myToken && $xenditTokenHeader !== $myToken) {
            return Response::json(['message' => 'Invalid Token'], 403);
        }

        $data = $request->all();
        // Xendit kadang kirim 'status', kadang untuk FVA beda format. Ini handler umum Invoice.
        $status = $data['status'] ?? null; 
        $externalId = $data['external_id'] ?? null;

        $trx = Transaction::where('reference', $externalId)->first();

        if ($trx) {
            if ($status == 'PAID' || $status == 'SETTLED') {
                if ($trx->status == 'UNPAID') {
                    $this->processSuccess($trx, $digiflazz, "Xendit");
                }
            } elseif ($status == 'EXPIRED') {
                $trx->update([
                    'status' => 'EXPIRED',
                    'processing_status' => 'FAILED'
                ]);
            }
        }

        return Response::json(['success' => true]);
    }

    // ==========================================
    // 3. HANDLER CALLBACK MIDTRANS
    // ==========================================
    public function handleMidtrans(Request $request, DigiflazzService $digiflazz)
    {
        // 1. Konfigurasi
        \Midtrans\Config::$serverKey = Configuration::getBy('midtrans_server_key');
        \Midtrans\Config::$isProduction = (Configuration::getBy('midtrans_mode') == 'production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return Response::json(['message' => 'Invalid Notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $trx = Transaction::where('reference', $orderId)->first();

        if ($trx) {
            if ($transactionStatus == 'capture') {
                if ($notif->payment_type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $trx->update(['status' => 'UNPAID']);
                    } else {
                        $this->processSuccess($trx, $digiflazz, "Midtrans CC");
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->processSuccess($trx, $digiflazz, "Midtrans Settlement");
            } elseif (in_array($transactionStatus, ['pending'])) {
                $trx->update(['status' => 'UNPAID']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $trx->update([
                    'status' => 'EXPIRED',
                    'processing_status' => 'FAILED'
                ]);
            }
        }

        return Response::json(['success' => true]);
    }

    // ==========================================
    // HELPER: LOGIKA SUKSES (PUSAT)
    // ==========================================
    private function processSuccess($trx, $digiflazz, $providerName)
    {
        // Cek Double Hit (Mencegah saldo bertambah 2x jika callback masuk 2x)
        if ($trx->status == 'PAID') {
            return;
        }

        try {
            DB::beginTransaction();

            // 1. Cek Apakah Ini Deposit Saldo?
            // Kriteria: product_code == 'DEPOSIT' ATAU service_name mengandung kata 'Deposit'
            $isDeposit = ($trx->product_code == 'DEPOSIT') || 
                         (stripos($trx->service_name, 'Deposit') !== false) ||
                         ($trx->game_code == 'DEPOSIT');

            if ($isDeposit) {
                // --- LOGIKA DEPOSIT ---
                $trx->update([
                    'status' => 'PAID',
                    'processing_status' => 'SUCCESS', // Deposit langsung sukses, tidak perlu ke Digiflazz
                    'sn' => 'DEP/' . time() . '/' . rand(100,999)
                ]);

                $user = $trx->user;
                if ($user) {
                    $user->balance += $trx->amount; // Tambah saldo user
                    $user->save();
                    Log::info("{$providerName} Deposit Success: {$trx->reference} User: {$user->name} (+{$trx->amount})");
                }
            } else {
                // --- LOGIKA PEMBELIAN GAME ---
                $trx->update(['status' => 'PAID']);
                
                // Kirim request ke Digiflazz
                // Kita commit database dulu agar status PAID tersimpan sebelum request API yang memakan waktu
                DB::commit(); 
                
                try {
                    $digiflazz->processTransaction($trx);
                    Log::info("{$providerName} Game Trx Success: {$trx->reference} -> Sent to Digiflazz");
                } catch (\Exception $e) {
                    Log::error("Digiflazz Error after Payment: " . $e->getMessage());
                    // Jangan ubah status jadi failed, biarkan admin cek manual jika digiflazz error
                }
                return; // Return karena sudah commit manual di atas
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Callback Error {$providerName}: " . $e->getMessage());
        }
    }
}