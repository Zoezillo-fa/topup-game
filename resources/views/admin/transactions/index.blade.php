<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-light me-2">Produk</a>
            <a href="#" class="btn btn-sm btn-primary">Transaksi</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Riwayat Transaksi Masuk</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Target (ID & Nick)</th>
                            <th>Harga</th>
                            <th>Status Bayar</th>
                            <th>Status Kirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td>
                                <small class="text-muted">{{ $trx->created_at->format('d M Y') }}</small><br>
                                <small>{{ $trx->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $trx->reference }}</span>
                            </td>
                            <td>{{ $trx->product_code }}</td>
                            <td>
                                <div>{{ $trx->user_id_game }}</div>
                                @if($trx->nickname_game)
                                    <small class="text-primary fw-bold">{{ $trx->nickname_game }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($trx->status == 'PAID')
                                    <span class="badge bg-success">LUNAS</span>
                                @elseif($trx->status == 'EXPIRED')
                                    <span class="badge bg-danger">HANGUS</span>
                                @else
                                    <span class="badge bg-warning text-dark">BELUM BAYAR</span>
                                @endif
                            </td>
                            <td>
                                @if($trx->processing_status == 'SUCCESS')
                                    <span class="badge bg-success">SUKSES</span>
                                @elseif($trx->processing_status == 'FAILED')
                                    <span class="badge bg-danger">GAGAL</span>
                                @elseif($trx->processing_status == 'PROCESS')
                                    <span class="badge bg-info text-dark">PROSES</span>
                                @else
                                    <span class="badge bg-secondary">PENDING</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada transaksi masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

</body>
</html>