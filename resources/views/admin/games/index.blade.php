@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Tambah Game</div>
            <div class="card-body">
                <form action="{{ route('admin.games.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label>Nama Game</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Kode URL (Slug)</label>
                        <input type="text" name="code" class="form-control" placeholder="cth: mobile-legends" required>
                    </div>
                    <div class="mb-2">
                        <label>Publisher</label>
                        <input type="text" name="publisher" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Endpoint Cek ID</label>
                        <input type="text" name="target_endpoint" class="form-control" placeholder="cth: ml, ff, pubgm" required>
                    </div>
                    <div class="mb-2">
                        <label>Link Logo</label>
                        <input type="text" name="thumbnail" class="form-control" placeholder="/images/logo/..." required>
                    </div>
                    <div class="mb-3">
                        <label>Link Banner</label>
                        <input type="text" name="banner" class="form-control" placeholder="/images/banner/..." required>
                    </div>
                    <button class="btn btn-primary w-100">Simpan Game</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Endpoint</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $game)
                        <tr>
                            <td>
                                <img src="{{ $game->thumbnail }}" width="30" class="me-2 rounded">
                                {{ $game->name }}
                            </td>
                            <td>{{ $game->code }}</td>
                            <td><span class="badge bg-info text-dark">{{ $game->target_endpoint }}</span></td>
                            <td>
                                <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Hapus game ini? Produk terkait mungkin error.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection