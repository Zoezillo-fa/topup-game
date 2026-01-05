<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentGatewayService;

class DepositController extends Controller
{
    public function index()
    {
        // 1. Ambil Manual Transfer
        $manualMethods = PaymentMethod::where('provider', 'manual')
                                      ->where('is_active', 1)
                                      ->get();

        // 2. Ambil QRIS Tripay (Kode biasanya QRIS / QRISC / QRIS2)
        $tripayQris = PaymentMethod::where('provider', 'tripay')
                                   ->whereIn('code', ['QRIS', 'QRISC', 'QRIS2'])
                                   ->where('is_active', 1)
                                   ->first();

        return view('member.deposit.index', compact('manualMethods', 'tripayQris'));
    }

    public function store(Request $request, PaymentGatewayService $gateway)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|exists:payment_methods,code'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $method = PaymentMethod::where('code', $request->payment_method)->firstOrFail();
            
            // Format Invoice: DEP-USERID-TIMESTAMP
            $reference = 'DEP-' . $user->id . '-' . time();

            $transaction = Transaction::create([
                'user_id'           => $user->id,
                'reference'         => $reference,
                'product_code'      => 'DEPOSIT',
                'game_code'         => 'DEPOSIT',
                'service_name'      => 'Isi Saldo ' . number_format($request->amount),
                'target'            => $user->phonenumber ?? '-',
                'amount'            => $request->amount,
                'price'             => $request->amount,
                'status'            => 'UNPAID',
                'processing_status' => 'PENDING',
                'payment_method'    => $method->code
            ]);

            DB::commit();

            // Proses Pembayaran
            $process = $gateway->process($transaction, $method);

            if ($process['success']) {
                return redirect($process['redirect_url']);
            } else {
                return back()->with('error', 'Gagal memproses pembayaran.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}