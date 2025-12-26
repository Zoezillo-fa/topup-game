@extends('layouts.admin')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Tambah Pengguna Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role (Peran)</label>
                <select name="role" class="form-select">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
                <div class="form-text">Admin memiliki akses penuh ke panel ini.</div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary fw-bold">SIMPAN DATA</button>
            </div>
        </form>
    </div>
</div>
@endsection