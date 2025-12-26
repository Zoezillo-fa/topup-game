@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Kode Promo & Voucher</h4>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success fw-bold border-0 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fw-bold border-0 shadow-sm mb-4">
        <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
    </div>
@endif


<div class="row">
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white fw-bold py-3">
                <i class="bi bi-plus-circle me-2"></i> Buat Promo Baru
            </div>
            <div class="card-body">
                <form action="{{ route('admin.promos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kode Voucher</label>
                        <input type="text" name="code" class="form-control text-uppercase font-monospace fw-bold" placeholder="Cth: MABAR50" value="{{ old('code') }}" required>
                        <div class="form-text">Gunakan huruf & angka tanpa spasi.</div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Tipe Potongan</label>
                            <select name="type" class="form-select bg-light">
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Persen (%)</option>
                                <option value="flat" {{ old('type') == 'flat' ? 'selected' : '' }}>Rupiah (Rp)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Nilai</label>
                            <input type="number" name="value" class="form-control" placeholder="10 / 5000" value="{{ old('value') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Batas Pemakaian (Max Usage)</label>
                        <input type="number" name="max_usage" class="form-control" value="{{ old('max_usage', 0) }}">
                        <div class="form-text">Isi <strong>0</strong> jika ingin Unlimited (Tak Terbatas).</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        <i class="bi bi-save me-2"></i> SIMPAN PROMO
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                Daftar Voucher Aktif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">Kode Promo</th>
                                <th>Besar Diskon</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promos as $promo)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="badge bg-dark fs-6 font-monospace mb-1" style="width: fit-content;">
                                            {{ $promo->code }}
                                        </span>
                                        <small class="text-muted">
                                            Limit: {{ $promo->max_usage == 0 ? 'Unlimited' : $promo->max_usage . 'x' }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    @if($promo->type == 'percent')
                                        <div class="fw-bold text-primary fs-5">{{ intval($promo->value) }}%</div>
                                        <small class="text-muted">Potongan Persen</small>
                                    @else
                                        <div class="fw-bold text-success fs-5">Rp {{ number_format($promo->value, 0, ',', '.') }}</div>
                                        <small class="text-muted">Potongan Flat</small>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.promos.toggle', $promo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $promo->is_active ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">
                                            {{ $promo->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher {{ $promo->code }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Voucher">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted mb-2"><i class="bi bi-ticket-perforated fs-1"></i></div>
                                    <h6 class="fw-bold text-muted">Belum ada kode promo</h6>
                                    <small class="text-muted">Buat kode promo baru di formulir sebelah kiri.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection