<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi (Monitoring)
     */
    public function index()
    {
        // Ambil data transaksi, urutkan dari yang terbaru (latest)
        // Pagination 10 item per halaman agar tidak berat
        $transactions = Transaction::latest()->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Update status transaksi manual (Fitur Darurat)
     */
    public function update(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required'
        ]);

        // Cari transaksi dan update
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui manual.');
    }
}