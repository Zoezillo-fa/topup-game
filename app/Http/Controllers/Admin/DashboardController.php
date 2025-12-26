<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Grafik/Statistik Dashboard
        $totalPenjualan = Transaction::where('status', 'PAID')->sum('amount');
        $totalTransaksi = Transaction::count();
        $totalUser = User::where('role', 'member')->count();

        // Ambil 5 transaksi terakhir
        $latestTrx = Transaction::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('totalPenjualan', 'totalTransaksi', 'totalUser', 'latestTrx'));
    }
}