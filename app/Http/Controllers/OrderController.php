<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.check');
    }

    public function search(Request $request)
    {
        $request->validate([
            'invoice' => 'required|string'
        ]);

        // Cari transaksi berdasarkan Reference (Nomor Invoice)
        $transaction = Transaction::where('reference', $request->invoice)->first();

        if (!$transaction) {
            return back()->with('error', 'Pesanan tidak ditemukan. Mohon cek kembali nomor invoice Anda.');
        }

        // Ambil nama produk manual (karena belum ada relasi di model Transaction)
        $product = Product::where('code', $transaction->product_code)->first();
        $productName = $product ? $product->name : $transaction->product_code;

        return view('order.check', compact('transaction', 'productName'));
    }
}