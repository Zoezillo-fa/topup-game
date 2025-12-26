@extends('layouts.admin')

@section('title', 'Monitoring Transaksi')

@section('content')
<style>
    .card-gaming {
        background-color: #212529;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }
    .table-gaming {
        --bs-table-bg: #212529;
        --bs-table-color: #e5e7eb;
        --bs-table-border-color: rgba(255, 255, 255, 0.1);
        --bs-table-hover-bg: rgba(250, 204, 21, 0.05);
    }
    .text-gold { color: #facc15 !important; }
</style>

<div class="container-fluid px-4 py-4">

    @if(session('success'))
        <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-gaming rounded-4 overflow-hidden">
        <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center">
            <h6 class="m-0 fw-bold text-gold text-uppercase ls-1">
                <i class="bi bi-activity me-2"></i> Live Transactions
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-gaming align-middle mb-0 text-nowrap">
                    <thead class="text-uppercase small fw-bold">
                        <tr style="border-bottom: 2px solid rgba(250, 204, 21, 0.3);">
                            <th class="py-3 ps-4 text-secondary">Waktu</th>
                            <th class="py-3 text-gold">Invoice</th>
                            <th class="py-3 text-secondary">User Game</th>
                            <th class="py-3 text-secondary">Item</th>
                            <th class="py-3 text-gold text-end">Harga</th>
                            <th class="py-3 text-center text-secondary">Bayar</th>
                            <th class="py-3 text-center text-secondary">Proses</th>
                            <th class="py-3 text-center text-secondary">Aksi Manual</th> </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="ps-4 text-secondary small">{{ $trx->created_at->format('d M, H:i') }}</td>
                            <td class="fw-bold text-white">{{ $trx->reference }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-white">{{ $trx->user_id_game }}</span>
                                    @if($trx->zone_id_game) <span class="small text-muted">Zone: {{ $trx->zone_id_game }}</span> @endif
                                </div>
                            </td>
                            <td class="text-light">{{ $trx->product_name ?? $trx->product_code }}</td>
                            <td class="fw-bold text-gold text-end">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            
                            <td class="text-center">
                                @if($trx->status == 'PAID')
                                    <span class="badge rounded-pill bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-3">LUNAS</span>
                                @elseif($trx->status == 'EXPIRED' || $trx->status == 'FAILED')
                                    <span class="badge rounded-pill bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25 px-3">GAGAL</span>
                                @else
                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3">MENUNGGU</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($trx->processing_status == 'SUCCESS')
                                    <i class="bi bi-check-circle-fill text-success fs-5" title="Sukses"></i>
                                @elseif($trx->processing_status == 'FAILED')
                                    <i class="bi bi-x-circle-fill text-danger fs-5" title="Gagal"></i>
                                @else
                                    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($trx->status == 'UNPAID')
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="{{ route('admin.transactions.update', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="PAID" class="btn btn-outline-success" 
                                                    onclick="return confirm('Yakin ingin MENYETUJUI transaksi ini secara manual?')" title="Terima Manual">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.transactions.update', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="FAILED" class="btn btn-outline-danger" 
                                                    onclick="return confirm('Yakin ingin MEMBATALKAN transaksi ini?')" title="Batalkan Manual">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small"><i class="bi bi-lock-fill"></i> Terkunci</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada transaksi masuk hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($transactions->hasPages())
        <div class="card-footer bg-transparent border-top border-secondary border-opacity-25 py-3">
            <div class="d-flex justify-content-end">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Auto Refresh 15 detik
    setInterval(function(){ window.location.reload(); }, 15000);
</script>
@endsection