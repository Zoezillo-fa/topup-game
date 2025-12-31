<!DOCTYPE html>
<html>
<head>
    <title>Login Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menggunakan style yang SAMA dengan Admin Login */
        body { 
            background: #242733; 
            color: white; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .form-control:focus { box-shadow: none; border-color: #ffc107; }
        .card { background: #1a1c23; }
    </style>
</head>
<body>
    <div class="card p-4 border-0 shadow-lg" style="width: 350px;">
        <h3 class="text-center text-white mb-4">Login Member</h3>
        
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger p-2 small border-0 mb-3">{{ $errors->first() }}</div>
            @endif

            <div class="mb-3">
                <label class="text-white small mb-1">Email</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required placeholder="Contoh: user@gmail.com">
            </div>

            <div class="mb-4">
                <label class="text-white small mb-1">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required placeholder="••••••">
            </div>

            <button class="btn btn-warning w-100 fw-bold mb-3">MASUK SEKARANG</button>

            <div class="text-center">
                <a href="{{ route('register') }}" class="text-white-50 text-decoration-none small">
                    Belum punya akun? <span class="text-warning">Daftar disini</span>
                </a>
            </div>
        </form>
    </div>
</body>
</html>