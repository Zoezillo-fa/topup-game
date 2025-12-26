@extends('layouts.main')

@section('title', 'Cek Pesanan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card bg-dark border-secondary border-opacity-25 shadow-lg mb-4">
                <div class="card-header border-secondary border-opacity-25 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-search me-2 text-warning"></i> Cek Status Pesanan</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 small mb-3">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('order.search') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white-50">Nomor Invoice</label>
                            <input type="text" name="invoice" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: INV-65123xxxxx" value="{{ request('invoice') }}" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">CEK SEKARANG</button>
                    </form>
                </div>
            </div>

            @if(isset($transaction))
            <div class="card bg-dark border-secondary border-opacity-25 shadow-lg">
                <div class="card-header bg-warning bg-opacity-10 border-warning border-opacity-25 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-warning">Detail Pesanan</h6>
                        <span class="badge bg-secondary">{{ $transaction->reference }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless mb-0">
                            <tr>
                                <td class="text-white-50 w-50">Item Produk</td>
                                <td class="fw-bold text-end">{{ $productName }}</td>
                            </tr>
                            <tr>
                                <td class="text-white-50">User ID / Tujuan</td>
                                <td class="fw-bold text-end">{{ $transaction->user_id_game }}</td>
                            </tr>
                             <tr>
                                <td class="text-white-50">Nickname</td>
                                <td class="fw-bold text-end">{{ $transaction->nickname_game ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-white-50">Harga</td>
                                <td class="fw-bold text-end text-warning">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-white-50">Status Pembayaran</td>
                                <td class="text-end">
                                    @if($transaction->status == 'PAID')
                                        <span class="badge bg-success">LUNAS</span>
                                    @elseif($transaction->status == 'EXPIRED')
                                        <span class="badge bg-danger">KADALUARSA</span>
                                    @else
                                        <span class="badge bg-warning text-dark">BELUM BAYAR</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-white-50">Status Pengiriman</td>
                                <td class="text-end">
                                    @if($transaction->processing_status == 'SUCCESS')
                                        <span class="badge bg-success">SUKSES TERKIRIM</span>
                                    @elseif($transaction->processing_status == 'FAILED')
                                        <span class="badge bg-danger">GAGAL</span>
                                    @else
                                        <span class="badge bg-info text-dark">DIPROSES</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection