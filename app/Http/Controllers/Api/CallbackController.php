<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Response;
use App\Services\DigiflazzService;

class CallbackController extends Controller
{
    public function handle(Request $request, DigiflazzService $digiflazz)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $privateKey = config('services.tripay.private_key');

        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== $callbackSignature) {
            return Response::json(['success' => false, 'message' => 'Invalid Signature'], 400);
        }

        $data = json_decode($json);
        $event = $request->server('HTTP_X_CALLBACK_EVENT');

        if ($event == 'payment_status') {
            if ($data->status == 'PAID') {
                $trx = Transaction::where('reference', $data->merchant_ref)->first();

                if ($trx && $trx->status == 'UNPAID') {
                    $trx->update(['status' => 'PAID']);
                    $digiflazz->processTransaction($trx);
                }
            }
        }

        return Response::json(['success' => true]);
    }
}