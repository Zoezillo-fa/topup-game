<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Top Up Game') - Store Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-glass shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-joystick fs-3 me-2 text-warning"></i> 
                <span>STORE GAME</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center fw-semibold text-uppercase small">
                    {{-- Link Beranda mengarah ke route 'home' --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    
                    {{-- Link Cek Pesanan --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('order.*') ? 'active' : '' }}" href="{{ route('order.check') }}">Cek Pesanan</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        @auth
                            {{-- LOGIKA: Jika user SUDAH login, tampilkan Dashboard sesuai Role --}}
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-gold-gradient rounded-pill px-4 py-2">
                                    <i class="bi bi-speedometer2 me-1"></i> Admin Panel
                                </a>
                            @else
                                {{-- Jika Member, bisa diarahkan ke home atau dashboard member (jika ada) --}}
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning rounded-pill px-4 py-2">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            @endif
                        @else
                            {{-- LOGIKA: Jika user BELUM login (Tamu) --}}
                            {{-- [PERBAIKAN] Mengarah ke route('login') bukan admin.login --}}
                            <a href="{{ route('login') }}" class="btn btn-gold-gradient rounded-pill px-4 py-2">
                                <i class="bi bi-person-fill me-1"></i> Masuk
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main style="padding-top: 100px; min-height: 80vh;">
        @yield('content')
    </main>

    <footer class="py-5 mt-5 bg-dark text-secondary border-top border-secondary">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white fw-bold mb-3">STORE GAME</h5>
                    <p class="small">Platform top up game termurah, tercepat, dan terpercaya. Proses otomatis 24 jam.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white fw-bold">Bantuan</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-decoration-none text-secondary">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-decoration-none text-secondary">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white fw-bold">Kontak</h6>
                    <p class="small"><i class="bi bi-whatsapp me-2"></i> 0812-3456-7890</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small">
                &copy; {{ date('Y') }} Store Game. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>