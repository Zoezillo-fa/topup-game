<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Configuration; 
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Services\DigiflazzService;

class CallbackController extends Controller
{
    // ==========================================
    // 1. HANDLER CALLBACK TRIPAY
    // ==========================================
    public function handleTripay(Request $request, DigiflazzService $digiflazz)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $privateKey = Configuration::getBy('tripay_private_key');

        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== $callbackSignature) {
            return Response::json(['success' => false, 'message' => 'Invalid Signature'], 400);
        }

        $data = json_decode($json);
        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if ($event == 'payment_status') {
            // Cari transaksi berdasarkan Reference
            $trx = Transaction::where('reference', $data->merchant_ref)->first();

            if ($trx) {
                // A. JIKA SUKSES
                if ($data->status == 'PAID') {
                    if ($trx->status == 'UNPAID') {
                        
                        // Cek apakah ini DEPOSIT atau PEMBELIAN GAME
                        if ($trx->service == 'DEPOSIT') {
                            // 1. Update Status Transaksi & Processing Status (Supaya dashboard tidak loading)
                            $trx->update([
                                'status' => 'PAID',
                                'processing_status' => 'SUCCESS', 
                                'sn' => 'DEP/' . time() // Serial Number Dummy
                            ]);

                            // 2. Tambah Saldo User
                            $user = $trx->user;
                            if ($user) {
                                $user->balance += $trx->amount;
                                $user->save();
                                Log::info("Tripay Deposit Success: {$trx->reference} - User: {$user->name} (+{$trx->amount})");
                            }
                        } else {
                            // Jika Pembelian Game -> Update PAID, biarkan Digiflazz urus processingnya
                            $trx->update(['status' => 'PAID']);
                            $digiflazz->processTransaction($trx);
                        }
                    }
                } 
                // B. JIKA GAGAL / EXPIRED / REFUND
                elseif (in_array($data->status, ['EXPIRED', 'FAILED', 'REFUND'])) {
                    $trx->update([
                        'status' => strtoupper($data->status),
                        'processing_status' => 'FAILED' // Supaya dashboard jelas gagal
                    ]);
                    Log::info("Tripay Transaction {$data->status}: {$trx->reference}");
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
        $xenditTokenHeader = $request->header('x-callback-token');
        $myToken = Configuration::getBy('xendit_callback_token');

        if ($myToken && $xenditTokenHeader !== $myToken) {
            return Response::json(['message' => 'Invalid Token'], 403);
        }

        $data = $request->all();
        $status = $data['status'] ?? null;
        $externalId = $data['external_id'] ?? null;

        // Cari transaksi
        $trx = Transaction::where('reference', $externalId)->first();

        if ($trx) {
            // A. JIKA SUKSES
            if ($status == 'PAID' || $status == 'SETTLED') {
                if ($trx->status == 'UNPAID') {
                    
                    if ($trx->service == 'DEPOSIT') {
                        // 1. Update Status & Processing (Fix Dashboard Loading)
                        $trx->update([
                            'status' => 'PAID',
                            'processing_status' => 'SUCCESS',
                            'sn' => 'DEP/' . time()
                        ]);

                        // 2. Tambah Saldo User
                        $user = $trx->user;
                        if ($user) {
                            $user->balance += $trx->amount;
                            $user->save();
                            Log::info("Xendit Deposit Success: {$trx->reference} - User: {$user->name} (+{$trx->amount})");
                        }
                    } else {
                        // Jika Pembelian Game
                        $trx->update(['status' => 'PAID']);
                        $digiflazz->processTransaction($trx);
                    }
                }
            }
            // B. JIKA GAGAL / EXPIRED
            elseif ($status == 'EXPIRED') {
                $trx->update([
                    'status' => 'EXPIRED',
                    'processing_status' => 'FAILED'
                ]);
                Log::info("Xendit Transaction Expired: {$trx->reference}");
            }
        }

        return Response::json(['success' => true]);
    }

    // ==========================================
    // 3. HANDLER CALLBACK MIDTRANS
    // ==========================================
    public function handleMidtrans(Request $request, DigiflazzService $digiflazz)
    {
        // Konfigurasi Library
        \Midtrans\Config::$serverKey = Configuration::getBy('midtrans_server_key');
        \Midtrans\Config::$isProduction = (Configuration::getBy('midtrans_mode') == 'production');

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return Response::json(['message' => 'Invalid Notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Cari transaksi
        $trx = Transaction::where('reference', $orderId)->first();

        if ($trx) {
            // Logic Status Midtrans
            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $trx->update(['status' => 'UNPAID']); // Masih menunggu konfirmasi
                    } else {
                        $this->processSuccess($trx, $digiflazz, 'Midtrans CC');
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                // SUKSES / LUNAS
                $this->processSuccess($trx, $digiflazz, 'Midtrans Settlement');
            } elseif ($transactionStatus == 'pending') {
                $trx->update(['status' => 'UNPAID']);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $trx->update([
                    'status' => 'EXPIRED',
                    'processing_status' => 'FAILED'
                ]);
            }
        }

        return Response::json(['success' => true]);
    }

    // Helper untuk memproses kesuksesan (supaya tidak duplikat kodingan)
    private function processSuccess($trx, $digiflazz, $logPrefix)
    {
        if ($trx->status == 'UNPAID') {
            if ($trx->service == 'DEPOSIT') {
                $trx->update([
                    'status' => 'PAID',
                    'processing_status' => 'SUCCESS',
                    'sn' => 'DEP/' . time()
                ]);
                $user = $trx->user;
                if ($user) {
                    $user->balance += $trx->amount;
                    $user->save();
                    Log::info("$logPrefix Success: {$trx->reference} (+{$trx->amount})");
                }
            } else {
                $trx->update(['status' => 'PAID']);
                $digiflazz->processTransaction($trx);
            }
        }
    }
}