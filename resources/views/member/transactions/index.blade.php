@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Riwayat Transaksi</h3>
        <a href="{{ route('deposit.index') }}" class="btn btn-sm btn-warning fw-bold">
            <i class="fas fa-plus me-1"></i> Deposit Baru
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="py-3">Invoice</th>
                            <th class="py-3">Layanan</th>
                            <th class="py-3 text-end">Nominal</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="px-4 text-muted small">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="fw-bold text-primary">{{ $trx->reference }}</td>
                            <td>
                                <span class="d-block fw-bold text-dark">{{ $trx->service_name ?? 'Topup Game' }}</span>
                                <small class="text-muted">{{ $trx->payment_method }}</small>
                            </td>
                            <td class="text-end fw-bold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($trx->status == 'PAID')
                                    <span class="badge bg-success">LUNAS</span>
                                @elseif($trx->status == 'EXPIRED')
                                    <span class="badge bg-danger">EXPIRED</span>
                                @elseif($trx->status == 'FAILED')
                                    <span class="badge bg-danger">GAGAL</span>
                                @else
                                    <span class="badge bg-warning text-dark">BELUM BAYAR</span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <a href="{{ route('order.check', ['invoice' => $trx->reference]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($transactions->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection