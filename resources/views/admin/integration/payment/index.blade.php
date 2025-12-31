@extends('layouts.admin') {{-- Sesuaikan dengan layout admin Anda --}}

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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        {{-- HEADER KARTU (DIPERBARUI: Ada Tombol Sync) --}}
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Channel Pembayaran</h6>
            
            <form action="{{ route('admin.integration.payment.sync') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyinkronkan data? Data lama mungkin akan diperbarui.');">
                @csrf
                <button type="submit" class="btn btn-sm btn-success shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Sync dari Tripay
                </button>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" width="10%">Logo</th>
                            <th>Kode</th>
                            <th>Nama Tampil</th>
                            <th>Biaya Flat (Rp)</th>
                            <th>Biaya Persen (%)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                        <tr class="align-middle">
                            {{-- 1. LOGO --}}
                            <td class="text-center bg-white">
                                @if($pay->image)
                                    <img src="{{ asset($pay->image) }}" alt="logo" class="rounded" style="height: 35px; max-width: 80px; object-fit: contain;">
                                @else
                                    <div class="badge bg-light text-secondary border">No Icon</div>
                                @endif
                            </td>

                            {{-- 2. KODE --}}
                            <td class="fw-bold text-dark">{{ $pay->code }}</td>

                            {{-- 3. NAMA --}}
                            <td>{{ $pay->name }}</td>

                            {{-- 4. BIAYA FLAT --}}
                            <td>
                                <span class="text-primary fw-bold">Rp {{ number_format($pay->flat_fee, 0, ',', '.') }}</span>
                            </td>

                            {{-- 5. BIAYA PERSEN --}}
                            <td>
                                @if($pay->percent_fee > 0)
                                    <span class="badge bg-info text-dark">{{ $pay->percent_fee }}%</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            {{-- 6. STATUS (YANG DIPERBAIKI) --}}
                            <td class="text-center">
                                @if($pay->is_active)
                                    {{-- Desain Aktif: Hijau Terang + Ikon Checklist --}}
                                    <span class="badge rounded-pill bg-success px-3 py-2 shadow-sm border border-success border-opacity-25">
                                        <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                    </span>
                                @else
                                    {{-- Desain Non-Aktif: Abu-abu Gelap + Ikon Silang --}}
                                    <span class="badge rounded-pill bg-secondary px-3 py-2 shadow-sm opacity-75">
                                        <i class="bi bi-x-circle-fill me-1"></i> Non-Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- 7. AKSI --}}
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" data-toggle="modal" data-target="#editModal{{ $pay->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $pay->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('admin.integration.payment.update', $pay->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="bi bi-pencil-fill me-2"></i>Edit {{ $pay->name }}</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label class="fw-bold small text-uppercase text-muted">Nama Tampilan</label>
                                                <input type="text" name="name" class="form-control" value="{{ $pay->name }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="fw-bold small text-uppercase text-muted">Biaya Flat (Rp)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">Rp</span>
                                                            <input type="number" name="flat_fee" class="form-control fw-bold" value="{{ $pay->flat_fee }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="fw-bold small text-uppercase text-muted">Biaya Persen (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="percent_fee" class="form-control fw-bold" value="{{ $pay->percent_fee }}">
                                                            <span class="input-group-text bg-light">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="fw-bold small text-uppercase text-muted">Ganti Logo</label>
                                                <input type="file" name="image" class="form-control form-control-sm">
                                            </div>
                                            <div class="alert alert-light border d-flex align-items-center" role="alert">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" id="active{{ $pay->id }}" name="is_active" {{ $pay->is_active ? 'checked' : '' }} style="cursor: pointer; transform: scale(1.3);">
                                                    <label class="form-check-label fw-bold ms-2" for="active{{ $pay->id }}" style="cursor: pointer;">Aktifkan Pembayaran Ini</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-link text-secondary text-decoration-none" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-wallet2 display-4 mb-3 opacity-50"></i>
                                    <h5 class="fw-bold">Belum ada metode pembayaran</h5>
                                    <p class="small">Klik tombol "Sync dari Tripay" di pojok kanan atas.</p>
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
@endsection