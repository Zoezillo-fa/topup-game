@extends('layouts.admin')

@section('title', 'Kelola Game')

@section('content')
<div class="container-fluid py-3">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Kelola Game</h4>
            <p class="text-muted small mb-0">Atur daftar game yang tersedia di website Anda.</p>
        </div>
        
        <form action="{{ route('admin.games.sync') }}" method="POST" onsubmit="return confirm('Sistem akan menarik semua kategori GAME dari Digiflazz (Mobile Legends, FF, dll) dan menambahkannya ke database. Lanjutkan?');">
            @csrf
            <button type="submit" class="btn btn-warning fw-bold shadow-sm">
                <i class="bi bi-cloud-download-fill me-2"></i> AMBIL GAME DARI DIGIFLAZZ
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold m-0 text-primary">Tambah Game Manual</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Game</label>
                            <input type="text" name="name" class="form-control" placeholder="Cth: Mobile Legends" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kode Unik (Slug)</label>
                            <input type="text" name="code" class="form-control" placeholder="Cth: mobile-legends" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Slug URL</label>
                            <input type="text" name="slug" class="form-control" placeholder="Cth: mobile-legends" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Brand Digiflazz (Opsional)</label>
                            <input type="text" name="brand_digiflazz" class="form-control" placeholder="Cth: MOBILE LEGENDS">
                            <div class="form-text text-muted x-small">Isi jika ingin fitur Sync Produk Otomatis lebih akurat.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Endpoint Cek ID</label>
                            <input type="text" name="endpoint" class="form-control" placeholder="Cth: ml, ff, genshin">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Logo (Thumbnail)</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Banner</label>
                            <input type="file" name="banner" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Game</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Game</th>
                                    <th class="py-3">Kode/Slug</th>
                                    <th class="py-3">Brand Digiflazz</th> <th class="py-3 text-center">Cek ID</th>
                                    <th class="pe-4 py-3 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($games as $game)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($game->thumbnail)
                                                <img src="{{ asset($game->thumbnail) }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-joystick text-secondary"></i>
                                                </div>
                                            @endif
                                            <span class="fw-bold text-dark">{{ $game->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $game->code }}</span>
                                    </td>
                                    <td>
                                        @if($game->brand_digiflazz)
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $game->brand_digiflazz }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($game->endpoint)
                                            <span class="badge bg-success bg-opacity-10 text-success">{{ $game->endpoint }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Hapus game ini? Semua produk di dalamnya juga akan terhapus!');">
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
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        Belum ada game. <br>
                                        Silakan tambah manual atau klik tombol <b>"Ambil Game Dari Digiflazz"</b> di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $games->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection