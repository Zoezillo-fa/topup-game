@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Game</h1>
    <a href="{{ route('admin.games.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit: {{ $game->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Game</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $game->name) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Slug (URL)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $game->slug) }}" required>
                        <small class="text-muted">Contoh: mobile-legends (Tanpa spasi)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Publisher / Pengembang</label>
                        <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $game->publisher) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Brand Code (Digiflazz)</label>
                        <input type="text" name="brand" class="form-control" value="{{ $game->brand }}" readonly>
                        <small class="text-muted">Kode ini disinkronkan otomatis, jangan diubah manual.</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Target Endpoint (Khusus API Cek ID)</label>
                <input type="text" name="target_endpoint" class="form-control" value="{{ old('target_endpoint', $game->target_endpoint) }}">
                <small class="text-muted">Isi jika slug di website berbeda dengan slug di API Cek ID (Apigames/Vicloud).</small>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $game->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thumbnail (Kecil)</label><br>
                        @if($game->thumbnail)
                            <img src="{{ asset($game->thumbnail) }}" width="80" class="mb-2 rounded border">
                        @endif
                        <input type="file" name="thumbnail" class="form-control-file">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Banner (Besar)</label><br>
                        @if($game->banner)
                            <img src="{{ asset($game->banner) }}" width="150" class="mb-2 rounded border">
                        @endif
                        <input type="file" name="banner" class="form-control-file">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Status Game</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $game->is_active ? 'selected' : '' }}>Aktif (Tampil)</option>
                    <option value="0" {{ !$game->is_active ? 'selected' : '' }}>Non-Aktif (Sembunyi)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection