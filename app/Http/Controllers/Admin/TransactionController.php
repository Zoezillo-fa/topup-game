<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil data transaksi, urutkan dari yang terbaru
        // Kita juga meload (paginate) agar halamannya tidak berat jika datanya ribuan
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }
}