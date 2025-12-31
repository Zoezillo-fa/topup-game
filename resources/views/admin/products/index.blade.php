@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 text-primary fw-bold">Daftar Produk</h4>
        <p class="text-muted small mb-0">Kelola harga produk regular dan VIP.</p>
    </div>
    <a href="{{ route('admin.products.sync') }}" class="btn btn-success fw-bold shadow-sm">
        <i class="bi bi-cloud-arrow-down-fill me-2"></i> AMBIL DARI SUPPLIER
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase font-monospace small">Game</th>
                        <th class="py-3 text-secondary text-uppercase font-monospace small">Produk</th>
                        <th class="py-3 text-secondary text-uppercase font-monospace small text-end">Modal</th>
                        <th class="py-3 text-primary text-uppercase font-monospace small text-end">Harga Member</th>
                        <th class="py-3 text-warning text-uppercase font-monospace small text-end">Harga VIP</th>
                        <th class="py-3 text-secondary text-uppercase font-monospace small text-center">Status</th>
                        <th class="pe-4 py-3 text-secondary text-uppercase font-monospace small text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-secondary rounded-pill px-3">{{ $product->game_code }}</span>
                        </td>
                        
                        <td>
                            <div class="fw-bold text-dark">{{ $product->name }}</div>
                            <small class="text-muted font-monospace">{{ $product->code }}</small>
                        </td>

                        <td class="text-end text-danger fw-medium">
                            Rp {{ number_format($product->cost_price) }}
                        </td>

                        <td class="text-end">
                            <span class="fw-bold text-dark">Rp {{ number_format($product->price) }}</span>
                        </td>

                        <td class="text-end">
                            <span class="fw-bold text-warning">Rp {{ number_format($product->price_vip) }}</span>
                        </td>

                        <td class="text-center">
                            @if($product->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Aktif</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Gangguan</span>
                            @endif
                        </td>

                        <td class="pe-4 text-center">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm rounded-circle" style="width: 32px; height: 32px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            Belum ada produk. Silakan klik tombol "Ambil Dari Supplier".
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3 d-flex justify-content-end">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection