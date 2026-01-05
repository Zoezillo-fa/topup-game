<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi milik user yang login
        $transactions = Transaction::where('user_id', Auth::id())
                                   ->latest()
                                   ->paginate(10); // 10 per halaman

        return view('member.transactions.index', compact('transactions'));
    }
}