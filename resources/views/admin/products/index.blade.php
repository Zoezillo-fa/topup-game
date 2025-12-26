@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Daftar Produk</h4>
    <a href="{{ route('admin.products.sync') }}" class="btn btn-success fw-bold">
        <i class="bi bi-cloud-arrow-down-fill me-2"></i> AMBIL DARI SUPPLIER
    </a>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Game</th>
                        <th>Nama Produk</th>
                        <th>Modal</th>
                        <th>Harga Jual</th>
                        <th>Margin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4"><span class="badge bg-secondary">{{ $product->game_code }}</span></td>
                        <td>
                            {{ $product->name }} <br>
                            <small class="text-muted">{{ $product->code }}</small>
                        </td>
                        <td class="text-danger">Rp {{ number_format($product->cost_price) }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($product->price) }}</td>
                        <td>
                            @php $profit = $product->price - $product->cost_price; @endphp
                            <span class="badge bg-success">+Rp {{ number_format($profit) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5">Belum ada produk. Klik "Ambil dari Supplier".</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $products->links() }}</div>
</div>
@endsection