@extends('layouts.admin')

@section('title', 'Kelola Metode Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Metode Pembayaran</h1>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- [BARU] CARD STATUS PAYMENT GATEWAY (RE-DESIGN) --}}
    <div class="card shadow-sm mb-4 border-start-primary" style="border-left: 5px solid #4e73df;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                {{-- Bagian Kiri: Penjelasan --}}
                <div class="col-lg-7 mb-3 mb-lg-0">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-sliders me-2 text-primary"></i>Status Payment Gateway
                    </h5>
                    <p class="text-muted small mb-0">
                        Atur gateway mana yang ingin diaktifkan. <br>
                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Peringatan:</span> 
                        Jika gateway dimatikan (OFF), metode pembayarannya akan <strong>dihapus</strong> saat Sync Otomatis.
                    </p>
                </div>

                {{-- Bagian Kanan: Tombol Switch yang Lebih Bagus --}}
                <div class="col-lg-5">
                    <form action="{{ route('admin.integration.payment.status') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-lg-end gap-3">
                            
                            {{-- Switch Tripay --}}
                            <div class="d-flex align-items-center border rounded p-2 px-3 bg-white shadow-sm" style="min-width: 140px;">
                                <div class="flex-grow-1">
                                    <span class="fw-bold d-block text-dark" style="font-size: 0.9rem;">Tripay</span>
                                    @if(($gatewayStatus['tripay'] ?? false))
                                        <span class="badge bg-success" style="font-size: 0.65rem;">AKTIF</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 0.65rem;">NON-AKTIF</span>
                                    @endif
                                </div>
                                <div class="form-check form-switch ms-3 mb-0">
                                    <input class="form-check-input" type="checkbox" name="tripay" 
                                        {{ ($gatewayStatus['tripay'] ?? false) ? 'checked' : '' }} 
                                        onchange="this.form.submit()" 
                                        style="cursor: pointer; transform: scale(1.4); margin-left: 0;">
                                </div>
                            </div>
                            
                            {{-- Switch Xendit --}}
                            <div class="d-flex align-items-center border rounded p-2 px-3 bg-white shadow-sm" style="min-width: 140px;">
                                <div class="flex-grow-1">
                                    <span class="fw-bold d-block text-dark" style="font-size: 0.9rem;">Xendit</span>
                                    @if(($gatewayStatus['xendit'] ?? false))
                                        <span class="badge bg-primary" style="font-size: 0.65rem;">AKTIF</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 0.65rem;">NON-AKTIF</span>
                                    @endif
                                </div>
                                <div class="form-check form-switch ms-3 mb-0">
                                    <input class="form-check-input" type="checkbox" name="xendit" 
                                        {{ ($gatewayStatus['xendit'] ?? false) ? 'checked' : '' }} 
                                        onchange="this.form.submit()" 
                                        style="cursor: pointer; transform: scale(1.4); margin-left: 0;">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        {{-- HEADER KARTU --}}
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
            <h6 class="m-0 fw-bold text-primary">Daftar Channel Pembayaran</h6>
            
            <div>
                {{-- Tombol Tambah Manual --}}
                <button type="button" class="btn btn-sm btn-primary shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Manual
                </button>

                {{-- [UPDATE] Tombol Sync Otomatis --}}
                <form action="{{ route('admin.integration.payment.sync') }}" method="POST" class="d-inline" onsubmit="return confirm('Sync Otomatis akan:\n1. Menambahkan metode baru dari Gateway yang AKTIF.\n2. MENGHAPUS metode dari Gateway yang NON-AKTIF.\n\nApakah Anda yakin ingin melanjutkan?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning fw-bold text-dark shadow-sm">
                        <i class="bi bi-arrow-repeat me-1"></i> Sync Otomatis
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="8%">Logo</th>
                            <th>Provider</th>
                            <th>Kode</th>
                            <th>Nama Tampil</th>
                            <th>Biaya Flat</th>
                            <th>Biaya (%)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                        <tr>
                            {{-- LOGO --}}
                            <td class="text-center bg-white">
                                @if($pay->image)
                                    @php $imgSrc = \Illuminate\Support\Str::startsWith($pay->image, 'http') ? $pay->image : asset($pay->image); @endphp
                                    <img src="{{ $imgSrc }}" alt="logo" class="rounded" style="height: 35px; max-width: 80px; object-fit: contain;">
                                @else
                                    <div class="badge bg-light text-secondary border">No Icon</div>
                                @endif
                            </td>

                            {{-- PROVIDER --}}
                            <td>
                                @if($pay->provider == 'tripay')
                                    <span class="badge bg-info text-dark">Tripay</span>
                                @elseif($pay->provider == 'xendit')
                                    <span class="badge bg-primary">Xendit</span>
                                @else
                                    <span class="badge bg-secondary">Manual</span>
                                @endif
                            </td>

                            {{-- INFO DATA --}}
                            <td class="fw-bold text-dark">{{ $pay->code }}</td>
                            <td>{{ $pay->name }}</td>
                            <td class="text-primary fw-bold">Rp {{ number_format($pay->flat_fee, 0, ',', '.') }}</td>
                            <td>
                                @if($pay->percent_fee > 0)
                                    <span class="badge bg-warning text-dark">{{ $pay->percent_fee }}%</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            
                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($pay->is_active)
                                    <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> Aktif</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-x-circle-fill me-1"></i> Non-Aktif</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $pay->id }}" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="editModal{{ $pay->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.integration.payment.update', $pay->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit {{ $pay->name }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 border-end">
                                                    <div class="mb-3">
                                                        <label class="fw-bold small text-uppercase">Nama Tampilan</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $pay->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="fw-bold small text-uppercase text-danger">Provider</label>
                                                        <select name="provider" class="form-select fw-bold">
                                                            <option value="tripay" {{ $pay->provider == 'tripay' ? 'selected' : '' }}>Tripay</option>
                                                            <option value="xendit" {{ $pay->provider == 'xendit' ? 'selected' : '' }}>Xendit</option>
                                                            <option value="manual" {{ $pay->provider == 'manual' ? 'selected' : '' }}>Manual</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="fw-bold small text-uppercase">Kode Metode</label>
                                                        <input type="text" name="code" class="form-control" value="{{ $pay->code }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label class="fw-bold small text-uppercase">Biaya Flat</label>
                                                                <input type="number" name="flat_fee" class="form-control" value="{{ $pay->flat_fee }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label class="fw-bold small text-uppercase">Biaya %</label>
                                                                <input type="number" step="0.01" name="percent_fee" class="form-control" value="{{ $pay->percent_fee }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="fw-bold small text-uppercase">Ganti Logo</label>
                                                        <input type="file" name="image" class="form-control">
                                                    </div>
                                                    <div class="mt-4">
                                                        <div class="form-check form-switch ps-0">
                                                            <div class="d-flex align-items-center">
                                                                <input class="form-check-input ms-0 me-2" type="checkbox" id="active{{ $pay->id }}" name="is_active" {{ $pay->is_active ? 'checked' : '' }} style="transform: scale(1.3);">
                                                                <label class="form-check-label fw-bold text-success" for="active{{ $pay->id }}">Aktifkan Pembayaran Ini</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-wallet2 display-4 mb-3 opacity-50"></i>
                                    <h5 class="fw-bold">Belum ada metode pembayaran</h5>
                                    <p class="small">Silakan aktifkan Gateway di atas, lalu klik "Sync Otomatis".</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE (TAMBAH MANUAL) --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.integration.payment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Manual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold">Nama Metode</label>
                                <input type="text" name="name" class="form-control" required placeholder="Contoh: Transfer Bank BCA">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Kode Unik</label>
                                <input type="text" name="code" class="form-control" required placeholder="MANUAL_BCA">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Provider</label>
                                <select name="provider" class="form-select">
                                    <option value="manual">Manual</option>
                                    <option value="xendit">Xendit</option>
                                    <option value="tripay">Tripay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6"><div class="mb-3"><label class="fw-bold">Flat Fee</label><input type="number" name="flat_fee" class="form-control" value="0"></div></div>
                                <div class="col-6"><div class="mb-3"><label class="fw-bold">% Fee</label><input type="number" step="0.01" name="percent_fee" class="form-control" value="0"></div></div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Logo</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="mt-3">
                                <div class="form-check form-switch ps-0">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" id="activeNew" name="is_active" checked style="transform: scale(1.3);">
                                        <label class="form-check-label fw-bold" for="activeNew">Langsung Aktifkan?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection