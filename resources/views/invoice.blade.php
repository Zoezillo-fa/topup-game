<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $trx->reference }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <meta http-equiv="refresh" content="5"> 

    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; border: none; }
        .card-header { 
            border-top-left-radius: 15px !important; 
            border-top-right-radius: 15px !important; 
            background-color: #fff;
            border-bottom: 2px dashed #eee;
        }
        .status-paid { color: #198754; }
        .status-unpaid { color: #ffc107; }
        .status-expired { color: #dc3545; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5" style="max-width: 600px;">
    
    <a href="/" class="text-decoration-none text-muted mb-3 d-block">
        &laquo; Kembali ke Beranda
    </a>

    <div class="card shadow-lg">
        <div class="card-header text-center py-4">
            <h5 class="text-muted mb-0">Nomor Invoice</h5>
            <h3 class="fw-bold">{{ $trx->reference }}</h3>
        </div>
        
        <div class="card-body p-4">
            
            <div class="text-center mb-4">
                <p class="text-muted mb-1">Status Pembayaran</p>
                @if($trx->status == 'PAID')
                    <h1 class="status-paid fw-bold">LUNAS ✅</h1>
                @elseif($trx->status == 'EXPIRED')
                    <h1 class="status-expired fw-bold">KADALUARSA ❌</h1>
                @else
                    <h1 class="status-unpaid fw-bold">BELUM DIBAYAR ⏳</h1>
                @endif
            </div>

            <hr class="border-secondary opacity-25">

            @if($trx->status == 'PAID')
                <div class="alert @if($trx->processing_status == 'SUCCESS') alert-success @elseif($trx->processing_status == 'FAILED') alert-danger @else alert-info @endif text-center mb-4">
                    <strong>Status Pengiriman:</strong> <br>
                    
                    @if($trx->processing_status == 'SUCCESS')
                        <span class="fs-5">💎 BERHASIL DIKIRIM</span>
                    @elseif($trx->processing_status == 'PROCESS')
                        <span class="fs-5">🔄 SEDANG DIPROSES...</span>
                    @elseif($trx->processing_status == 'FAILED')
                        <span class="fs-5">❌ GAGAL (Hubungi Admin)</span>
                    @else
                        <span class="fs-5">⏳ MENUNGGU ANTRIAN...</span>
                    @endif
                </div>
            @endif

            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted">Tanggal Order</span>
                    <span class="fw-bold">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted">Item</span>
                    <span class="fw-bold">{{ $trx->product_code }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted">User ID</span>
                    <span class="fw-bold">{{ $trx->user_id_game }}</span>
                </li>

                @if($trx->nickname_game)
                <li class="list-group-item d-flex justify-content-between py-3 bg-light">
                    <span class="text-muted">Nickname</span>
                    <span class="fw-bold text-primary">{{ $trx->nickname_game }}</span>
                </li>
                @endif

                <li class="list-group-item d-flex justify-content-between py-3">
                    <span class="text-muted">Total Bayar</span>
                    <span class="fw-bold fs-5">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                </li>
            </ul>

            @if($trx->status == 'UNPAID' && $trx->tripay_reference)
                <div class="d-grid gap-2">
                    <a href="https://tripay.co.id/checkout/{{ $trx->tripay_reference }}" target="_blank" class="btn btn-primary btn-lg fw-bold">
                        BAYAR SEKARANG &raquo;
                    </a>
                    <small class="text-center text-muted">Klik tombol di atas untuk melihat Kode Bayar / QRIS</small>
                </div>
            @endif

            @if($trx->processing_status == 'FAILED')
                <div class="mt-3 text-center">
                    <small class="text-danger">
                        Jika saldo terpotong tapi status GAGAL, silakan hubungi WhatsApp Admin dengan menyertakan Nomor Invoice.
                    </small>
                </div>
            @endif

            <div class="mt-4 text-center">
                <a href="/" class="btn btn-outline-secondary btn-sm">Beli Lagi / Transaksi Baru</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>