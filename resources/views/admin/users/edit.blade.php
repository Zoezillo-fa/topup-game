@extends('layouts.admin')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Edit Pengguna: {{ $user->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru <small class="text-muted">(Opsional)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengganti password">
            </div>

            <div class="mb-3">
                <label class="form-label">Role (Peran)</label>
                <select name="role" class="form-select">
                    <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary fw-bold">UPDATE DATA</button>
            </div>
        </form>
    </div>
</div>
@endsection