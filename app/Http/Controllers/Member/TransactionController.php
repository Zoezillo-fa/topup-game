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
        // Ambil data transaksi milik user yang sedang login
        $transactions = Transaction::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        // Tampilkan ke view
        return view('member.transactions.index', compact('transactions'));
    }
}