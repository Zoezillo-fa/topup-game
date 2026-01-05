@extends('layouts.admin')

@section('title', 'Monitoring Transaksi')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Transaksi</h1>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pesanan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-left-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Terbaru</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>User Game</th>
                            <th>Item Produk</th>
                            <th>Harga</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Proses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="small text-muted">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td class="font-weight-bold text-primary">
                                #{{ $trx->reference }}
                                @if($trx->payment_method == 'MANUAL')
                                    <span class="badge bg-secondary ms-1" style="font-size: 0.6rem;">MANUAL</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $trx->user_id_game }}</span>
                                    @if($trx->zone_id_game) <span class="small text-muted">({{ $trx->zone_id_game }})</span> @endif
                                </div>
                            </td>
                            <td>{{ $trx->product_name ?? $trx->product_code }}</td>
                            <td class="fw-bold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            
                            <td class="text-center">
                                @if($trx->status == 'PAID')
                                    <span class="badge bg-success">LUNAS</span>
                                @elseif($trx->status == 'EXPIRED')
                                    <span class="badge bg-danger">EXPIRED</span>
                                @elseif($trx->status == 'FAILED')
                                    <span class="badge bg-danger">GAGAL</span>
                                @else
                                    <span class="badge bg-warning text-dark">UNPAID</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($trx->processing_status == 'SUCCESS')
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Sukses</span>
                                @elseif($trx->processing_status == 'FAILED')
                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Gagal</span>
                                @elseif($trx->processing_status == 'PROCESS')
                                    <span class="badge bg-info text-white"><i class="fas fa-spinner fa-spin"></i> Proses</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="dropdown no-arrow">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                                        <div class="dropdown-header">Aksi Manual:</div>
                                        
                                        @if($trx->status == 'UNPAID')
                                            <form action="{{ route('admin.transactions.update', $trx->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button type="submit" name="status" value="PAID" class="dropdown-item text-success" onclick="return confirm('Terima pembayaran ini?')">
                                                    <i class="fas fa-check me-2"></i> Set Lunas (Acc)
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.transactions.update', $trx->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button type="submit" name="status" value="FAILED" class="dropdown-item text-danger" onclick="return confirm('Batalkan pesanan ini?')">
                                                    <i class="fas fa-times me-2"></i> Batalkan
                                                </button>
                                            </form>
                                        @endif

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item small text-muted" href="#">Detail Log</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-gray-500">
                                <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-536.jpg" alt="Empty" style="height: 100px; opacity: 0.5;">
                                <p class="mt-2">Belum ada data transaksi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection