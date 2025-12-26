@extends('layouts.admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-primary bg-gradient h-100">
            <div class="card-body">
                <h6 class="text-white-50">Total Pendapatan</h6>
                <h3 class="fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                <i class="bi bi-cash-stack position-absolute top-0 end-0 p-3 fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-success bg-gradient h-100">
            <div class="card-body">
                <h6 class="text-white-50">Total Transaksi</h6>
                <h3 class="fw-bold">{{ $totalTransaksi }} <small class="fs-6">Order</small></h3>
                <i class="bi bi-cart-check position-absolute top-0 end-0 p-3 fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-warning bg-gradient h-100">
            <div class="card-body">
                <h6 class="text-dark opacity-75">Total Member</h6>
                <h3 class="fw-bold text-dark">{{ $totalUser }} <small class="fs-6">Orang</small></h3>
                <i class="bi bi-people position-absolute top-0 end-0 p-3 fs-1 opacity-25 text-dark"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">Transaksi Terakhir Masuk</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Invoice</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestTrx as $trx)
                <tr>
                    <td class="ps-4 fw-bold">{{ $trx->reference }}</td>
                    <td>{{ $trx->user_id_game }} ({{ $trx->nickname_game ?? '-' }})</td>
                    <td>Rp {{ number_format($trx->amount) }}</td>
                    <td>
                        @if($trx->status == 'PAID') <span class="badge bg-success">Lunas</span>
                        @elseif($trx->status == 'UNPAID') <span class="badge bg-warning text-dark">Pending</span>
                        @else <span class="badge bg-danger">Gagal</span> @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection