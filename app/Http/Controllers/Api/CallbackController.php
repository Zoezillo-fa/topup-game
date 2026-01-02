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
        
        // Ambil Private Key dari Database
        $privateKey = Configuration::getBy('tripay_private_key');

        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== $callbackSignature) {
            return Response::json(['success' => false, 'message' => 'Invalid Signature'], 400);
        }

        $data = json_decode($json);
        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {
                // Tripay 'merchant_ref' adalah Nomor Invoice kita
                $trx = Transaction::where('reference', $data->merchant_ref)->first();

                if ($trx && $trx->status == 'UNPAID') {
                    // 1. Update Status Transaksi jadi PAID
                    $trx->update(['status' => 'PAID']);
                    
                    // 2. Cek Jenis Layanan (Deposit atau Beli Game?)
                    if ($trx->service == 'DEPOSIT') {
                        // === LOGIKA DEPOSIT ===
                        $user = $trx->user;
                        if ($user) {
                            $user->balance += $trx->amount; // Tambah saldo user
                            $user->save();
                            Log::info("Tripay Deposit Success: {$trx->invoice} - User: {$user->name} (+{$trx->amount})");
                        }
                    } else {
                        // === LOGIKA GAME (DIGIFLAZZ) ===
                        // Proses Kirim Game Item ke Digiflazz
                        $digiflazz->processTransaction($trx);
                    }
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
        // A. Validasi Token (Keamanan)
        $xenditTokenHeader = $request->header('x-callback-token');
        $myToken = Configuration::getBy('xendit_callback_token');

        // Jika token diisi di admin, validasi tokennya
        if ($myToken && $xenditTokenHeader !== $myToken) {
            return Response::json(['message' => 'Invalid Token'], 403);
        }

        // B. Ambil Data
        $data = $request->all();

        // C. Cek Status Pembayaran
        // Xendit mengirim status 'PAID' (untuk Invoice/QRIS) atau 'SETTLED'
        $status = $data['status'] ?? null;
        $externalId = $data['external_id'] ?? null; // Invoice Number (DEP-XXX atau TRX-XXX)

        if ($status == 'PAID' || $status == 'SETTLED') {
            $trx = Transaction::where('reference', $externalId)->first();

            if ($trx && $trx->status == 'UNPAID') {
                // 1. Update Status Transaksi jadi PAID
                $trx->update(['status' => 'PAID']);
                
                // 2. Cek Jenis Layanan
                if ($trx->service == 'DEPOSIT') {
                    // === LOGIKA DEPOSIT ===
                    $user = $trx->user;
                    if ($user) {
                        $user->balance += $trx->amount; // Tambah saldo user
                        $user->save();
                        Log::info("Xendit Deposit Success: {$trx->invoice} - User: {$user->name} (+{$trx->amount})");
                    }
                } else {
                    // === LOGIKA GAME (DIGIFLAZZ) ===
                    // Proses Kirim Game Item ke Digiflazz
                    $digiflazz->processTransaction($trx);
                }
                
                Log::info("Xendit Payment Processed: " . $externalId);
            }
        }

        return Response::json(['success' => true]);
    }
}