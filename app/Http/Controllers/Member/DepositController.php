<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Configuration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DepositController extends Controller
{
    // 1. TAMPILKAN HALAMAN DEPOSIT
    public function index()
    {
        return view('member.deposit.index');
    }

    // 2. PROSES PEMBUATAN INVOICE DEPOSIT
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000', // Minimal deposit 10rb
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        
        // Buat Invoice ID Unik (DEP-...) agar beda dengan transaksi game (TRX-...)
        $invoiceId = 'DEP-' . strtoupper(Str::random(10));

        // 1. Simpan Transaksi ke Database
        // Pastikan tabel transactions Anda punya kolom yang fleksibel
        // Kita isi 'service' dengan 'DEPOSIT' agar callback tahu ini bukan pembelian game
        // 1. Simpan Transaksi ke Database
    $trx = Transaction::create([
        'user_id'          => $user->id,
        'reference'        => $invoiceId, // <--- TAMBAHKAN INI (Samakan dengan Invoice)
        'service'          => 'DEPOSIT', 
        'service_name'     => 'Isi Saldo Akun',
        'target'           => $user->phone ?? '-',
        'amount'           => $amount,
        'price'            => $amount,
        'status'           => 'UNPAID',
        'payment_method'   => 'QRIS',
        'payment_provider' => 'xendit'
    ]);

        // 2. Request ke API Xendit (Buat Invoice)
        $secretKey = Configuration::getBy('xendit_secret_key');
        
        try {
            $response = Http::withBasicAuth($secretKey, '')
                ->post('https://api.xendit.co/v2/invoices', [
                    'external_id'      => $invoiceId,
                    'amount'           => $amount,
                    'description'      => "Deposit Saldo " . $user->name,
                    'payer_email'      => $user->email,
                    'payment_methods'  => ['QRIS'], // <--- KUNCI: Kita paksa hanya QRIS
                    'success_redirect_url' => route('member.profile'), // Redirect setelah bayar
                    'failure_redirect_url' => route('deposit.index'),
                ]);

            $xendit = $response->json();

            if (isset($xendit['invoice_url'])) {
                // Redirect user langsung ke halaman pembayaran Xendit
                return redirect($xendit['invoice_url']);
            } else {
                return back()->with('error', 'Gagal membuat tagihan Xendit. ' . json_encode($xendit));
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan koneksi: ' . $e->getMessage());
        }
    }
}