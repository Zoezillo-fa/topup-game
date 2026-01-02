@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row">
        
        {{-- KOLOM KIRI --}}
        <div class="col-md-4 mb-4">
            
            {{-- 1. CARD PROFIL --}}
            <div class="card bg-dark border-secondary shadow-sm mb-3">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=facc15&color=1a1d26&size=128" 
                             class="rounded-circle shadow" alt="Avatar">
                    </div>
                    <h5 class="text-white fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-secondary small mb-3">{{ Auth::user()->email }}</p>
                    
                    @if(Auth::user()->role == 'vip')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-star-fill me-1"></i> VIP MEMBER
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                            MEMBER REGULER
                        </span>
                    @endif
                </div>
            </div>

            {{-- 2. CARD SALDO (BARU DITAMBAHKAN) --}}
            <div class="card bg-dark shadow-sm mb-3" style="border: 1px solid #facc15;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small text-uppercase fw-bold">Saldo Akun</span>
                        <i class="bi bi-wallet2 text-warning fs-4"></i>
                    </div>
                    <h2 class="fw-bold text-white mb-3">
                        {{-- Menggunakan null coalescing operator (?? 0) untuk keamanan --}}
                        Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}
                    </h2>
                    <div class="d-grid">
                        {{-- Cek apakah route deposit sudah ada agar tidak error --}}
                        <a href="{{ Route::has('deposit.index') ? route('deposit.index') : '#' }}" class="btn btn-warning fw-bold text-dark">
                            <i class="bi bi-plus-circle-fill me-2"></i> ISI SALDO
                        </a>
                    </div>
                </div>
            </div>

            {{-- 3. BANNER UPGRADE VIP --}}
            @if(Auth::user()->role != 'vip')
            <div class="card bg-gradient-gold border-0 mt-3 text-dark">
                <div class="card-body">
                    <h6 class="fw-bold"><i class="bi bi-crown me-2"></i>Upgrade ke VIP!</h6>
                    <p class="small mb-3">Dapatkan harga reseller termurah untuk semua game.</p>
                    <a href="{{ route('member.upgrade') }}" target="_blank" class="btn btn-dark w-100 btn-sm fw-bold text-warning">
                        HUBUNGI ADMIN
                    </a>
                </div>
            </div>
            @endif
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-md-8">
            
            @if(session('success'))
                <div class="alert alert-success border-0 text-white" style="background-color: #10b981;">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 text-white" style="background-color: #ef4444;">
                    <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            {{-- FORM EDIT PROFIL --}}
            <div class="card bg-dark border-secondary mb-4">
                <div class="card-header border-secondary bg-transparent py-3">
                    <h6 class="text-white mb-0 fw-bold"><i class="bi bi-person-gear me-2 text-warning"></i>Edit Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="text-secondary small mb-1">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-dark text-white border-secondary" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="mb-3">
                            <label class="text-secondary small mb-1">Email Address</label>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" value="{{ Auth::user()->email }}">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-warning fw-bold px-4">SIMPAN PROFIL</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FORM GANTI PASSWORD --}}
            <div class="card bg-dark border-secondary">
                <div class="card-header border-secondary bg-transparent py-3">
                    <h6 class="text-white mb-0 fw-bold"><i class="bi bi-lock me-2 text-warning"></i>Ganti Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="text-secondary small mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control bg-dark text-white border-secondary" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-secondary small mb-1">Password Baru</label>
                                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-secondary small mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-outline-warning px-4">UPDATE PASSWORD</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Tambahan CSS Khusus Halaman Ini --}}
<style>
    .bg-gradient-gold {
        background: linear-gradient(45deg, #facc15, #eab308);
    }
</style>
@endsection