@extends('layouts.main')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold text-white mb-1">
                <i class="bi bi-clock-history text-warning me-2"></i>Riwayat Transaksi
            </h3>
            <p class="text-secondary small mb-0">Pantau status pesanan dan top up Anda di sini.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="badge bg-dark border border-secondary p-2 px-3 rounded-pill">
                <i class="bi bi-wallet2 text-primary me-2"></i>Total Transaksi: {{ $transactions->total() }}
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 text-white d-flex align-items-center shadow-sm" role="alert" style="background: linear-gradient(90deg, #10b981, #059669);">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Transaction Card --}}
    <div class="card bg-dark border-secondary shadow-lg overflow-hidden" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="border-color: #374151;">
                    <thead class="text-secondary small text-uppercase" style="background-color: #1f2937;">
                        <tr>
                            <th class="py-3 ps-4">Invoice</th>
                            <th class="py-3">Item / Layanan</th>
                            <th class="py-3">Target (ID)</th>
                            <th class="py-3">Harga</th>
                            <th class="py-3">Status Bayar</th>
                            <th class="py-3">Status Proses</th>
                            <th class="py-3 pe-4 text-end">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr style="transition: all 0.2s;">
                            {{-- Kolom 1: Invoice --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3 rounded-circle d-flex align-items-center justify-content-center text-white" 
                                         style="width: 40px; height: 40px; background: {{ $trx->status == 'PAID' ? '#10b981' : ($trx->status == 'EXPIRED' ? '#ef4444' : '#f59e0b') }}">
                                        <i class="bi {{ $trx->service == 'DEPOSIT' ? 'bi-wallet-fill' : 'bi-controller' }}"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-white text-uppercase" style="font-family: monospace; letter-spacing: 1px;">
                                            #{{ $trx->reference }}
                                        </span>
                                        <span class="text-secondary small">{{ $trx->payment_method }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom 2: Produk --}}
                            <td>
                                <span class="d-block text-white fw-bold">{{ $trx->service_name }}</span>
                                <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary rounded-pill" style="font-size: 0.7rem;">
                                    {{ $trx->product_code }}
                                </span>
                            </td>

                            {{-- Kolom 3: Target --}}
                            <td>
                                <div class="text-white small">
                                    <i class="bi bi-person-badge text-secondary me-1"></i> {{ $trx->target }}
                                </div>
                                @if($trx->nickname_game != '-')
                                <div class="text-secondary x-small" style="font-size: 0.75rem;">
                                    IGN: {{ $trx->nickname_game }}
                                </div>
                                @endif
                            </td>

                            {{-- Kolom 4: Harga --}}
                            <td>
                                <span class="text-warning fw-bold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                            </td>

                            {{-- Kolom 5: Status Pembayaran --}}
                            <td>
                                @if($trx->status == 'PAID')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill">
                                        LUNAS
                                    </span>
                                @elseif($trx->status == 'UNPAID')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 rounded-pill">
                                        BELUM BAYAR
                                    </span>
                                @elseif($trx->status == 'EXPIRED')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill">
                                        KADALUARSA
                                    </span>
                                @elseif($trx->status == 'FAILED')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill">
                                        GAGAL
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom 6: Status Proses Game --}}
                            <td>
                                @if($trx->status == 'PAID')
                                    @if($trx->processing_status == 'SUCCESS')
                                        <div class="d-flex align-items-center text-success small fw-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> Sukses
                                        </div>
                                    @elseif($trx->processing_status == 'PENDING')
                                        <div class="d-flex align-items-center text-info small fw-bold">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Proses...
                                        </div>
                                    @elseif($trx->processing_status == 'FAILED')
                                        <div class="d-flex align-items-center text-danger small fw-bold">
                                            <i class="bi bi-x-circle-fill me-1"></i> Gagal Kirim
                                        </div>
                                    @endif
                                @else
                                    <span class="text-secondary small">-</span>
                                @endif
                            </td>

                            {{-- Kolom 7: Tanggal --}}
                            <td class="pe-4 text-end">
                                <span class="d-block text-white small">{{ $trx->created_at->format('d M Y') }}</span>
                                <span class="text-secondary small">{{ $trx->created_at->format('H:i') }} WIB</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-cart-x display-1 text-secondary opacity-25"></i>
                                    <h5 class="text-white mt-3">Belum ada transaksi</h5>
                                    <p class="text-secondary">Yuk mulai top up game favoritmu sekarang!</p>
                                    <a href="{{ route('home') }}" class="btn btn-warning rounded-pill px-4 fw-bold mt-2">
                                        <i class="bi bi-cart-plus me-1"></i> Order Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination Footer --}}
        @if($transactions->hasPages())
        <div class="card-footer bg-dark border-secondary py-3">
            <div class="d-flex justify-content-center">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Custom Scrollbar untuk Table Responsive */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #1f2937;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
    
    /* Hover Effect Baris Tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
</style>
@endsection