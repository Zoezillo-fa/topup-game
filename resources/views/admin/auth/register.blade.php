<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menggunakan style yang SAMA PERSIS dengan halaman Login */
        body { 
            background: #242733; 
            color: white; 
            min-height: 100vh; /* Pakai min-height agar bisa discroll jika form panjang */
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px;
        }
        .form-control:focus { box-shadow: none; border-color: #ffc107; }
    </style>
</head>
<body>
    <div class="card p-4 border-0 shadow-lg" style="width: 350px; background: #1a1c23;">
        <h3 class="text-center text-white mb-4">Daftar Admin</h3>
        
        <form method="POST" action="{{ route('admin.register.process') }}">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger p-2 small border-0 mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="mb-3">
                <label class="text-white small mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="form-control bg-dark text-white border-secondary" required placeholder="Nama Anda" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="text-white small mb-1">Email</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required placeholder="email@admin.com" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="text-white small mb-1">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required placeholder="Min. 6 karakter">
            </div>

            <div class="mb-4">
                <label class="text-white small mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary" required placeholder="Ulangi password">
            </div>

            <button class="btn btn-warning w-100 fw-bold mb-3">DAFTAR SEKARANG</button>

            <div class="text-center">
                <a href="{{ route('admin.login') }}" class="text-white-50 text-decoration-none small">
                    Sudah punya akun? <span class="text-warning">Login disini</span>
                </a>
            </div>
        </form>
    </div>
</body>
</html>