<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Top Up Game') - {{ \App\Models\Configuration::getBy('app_name') ?? 'Store Game' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-glass shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                {{-- LOGO & NAMA DINAMIS --}}
                @php 
                    $appLogo = \App\Models\Configuration::getBy('app_logo');
                    $appName = \App\Models\Configuration::getBy('app_name') ?? 'STORE GAME';
                @endphp

                @if($appLogo)
                    <img src="{{ asset($appLogo) }}" alt="Logo" height="35" class="me-2 rounded">
                    <span class="fw-bold fs-5">{{ $appName }}</span>
                @else
                    <i class="bi bi-joystick fs-3 me-2 text-warning"></i> 
                    <span>{{ $appName }}</span>
                @endif
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center fw-semibold text-uppercase small gap-2">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('pricelist') ? 'active' : '' }}" href="{{ route('pricelist') }}">Daftar Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('order.*') ? 'active' : '' }}" href="{{ route('order.check') }}">Cek Pesanan</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        @auth
                            {{-- LOGIKA: Jika user SUDAH login --}}
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-gold-gradient rounded-pill px-4 py-2 w-100 w-lg-auto">
                                    <i class="bi bi-speedometer2 me-1"></i> Panel
                                </a>
                            @else
                                {{-- MENU MEMBER (DROPDOWN) --}}
                                <div class="dropdown">
                                    <button class="btn btn-outline-warning rounded-pill px-4 py-2 dropdown-toggle text-uppercase w-100 w-lg-auto" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-person-circle me-1"></i> {{ Str::limit(Auth::user()->name, 10) }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-secondary mt-2">
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('member.profile') }}">
                                                <i class="bi bi-person-badge me-2 text-warning"></i> Profil Saya
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('order.check') }}">
                                                <i class="bi bi-clock-history me-2 text-warning"></i> Riwayat Pesanan
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider border-secondary"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item py-2 text-danger">
                                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @else
                            {{-- JIKA BELUM LOGIN --}}
                            <a href="{{ route('login') }}" class="btn btn-gold-gradient rounded-pill px-4 py-2 w-100 w-lg-auto">
                                <i class="bi bi-person-fill me-1"></i> Masuk
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content dengan Padding Responsive --}}
    <main style="padding-top: 100px; min-height: 80vh;" class="main-responsive">
        @yield('content')
    </main>

    <footer class="pt-5 pb-3 mt-5 bg-dark text-secondary border-top border-secondary">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-5 mb-5">
                    <a class="navbar-brand d-flex align-items-center mb-3" href="/">
                        @if($appLogo)
                            <img src="{{ asset($appLogo) }}" alt="Logo" height="40" class="me-2 rounded">
                            <span class="fw-bold text-white fs-4">{{ $appName }}</span>
                        @else
                            <i class="bi bi-joystick fs-2 me-2 text-warning"></i> 
                            <span class="fw-bold text-white fs-4">{{ $appName }}</span>
                        @endif
                    </a>
                    <p class="small leading-relaxed mb-4">
                        {{ \App\Models\Configuration::getBy('footer_description') ?? 'Platform top up game termurah, tercepat, dan terpercaya.' }}
                    </p>
                    
                    <h6 class="text-white fw-bold mb-2">Metode Pembayaran</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        @for ($i = 1; $i <= 4; $i++)
                            @php $img = \App\Models\Configuration::getBy('payment_logo_'.$i); @endphp
                            
                            @if($img)
                                <div class="bg-white rounded p-1 d-flex align-items-center justify-content-center" style="height:35px; min-width:55px;">
                                    <img src="{{ asset($img) }}" alt="Pay" style="max-height: 100%; max-width: 50px;">
                                </div>
                            @endif
                        @endfor

                        @if(!\App\Models\Configuration::getBy('payment_logo_1'))
                             <span class="text-secondary small">Bank Transfer, E-Wallet, QRIS</span>
                        @endif
                    </div>
                </div>

                <div class="col-6 col-lg-2 mb-4">
                    <h5 class="text-white fw-bold mb-3">Peta Situs</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}" class="text-secondary text-decoration-none hover-warning">Beranda</a></li>
                        <li><a href="{{ route('pricelist') }}" class="text-secondary text-decoration-none hover-warning">Daftar Harga</a></li>
                        <li><a href="{{ route('order.check') }}" class="text-secondary text-decoration-none hover-warning">Cek Pesanan</a></li>
                        <li><a href="{{ route('page.about') }}" class="text-secondary text-decoration-none hover-warning">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2 mb-4">
                    <h5 class="text-white fw-bold mb-3">Dukungan</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="https://wa.me/{{ \App\Models\Configuration::getBy('whatsapp_number') }}" class="text-secondary text-decoration-none hover-warning">WhatsApp Admin</a></li>
                        <li><a href="{{ route('page.terms') }}" class="text-secondary text-decoration-none hover-warning">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('page.privacy') }}" class="text-secondary text-decoration-none hover-warning">Privasi</a></li>
                        <li><a href="{{ route('page.faq') }}" class="text-secondary text-decoration-none hover-warning">FAQ</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 mb-4">
                    <h5 class="text-white fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-secondary fs-4 hover-warning"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-secondary fs-4 hover-warning"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="text-secondary fs-4 hover-warning"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="text-secondary fs-4 hover-warning"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

            </div>

            <hr class="border-secondary my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start small">
                    &copy; {{ date('Y') }} <span class="text-warning fw-bold">{{ $appName }}</span>. All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end small mt-2 mt-md-0">
                    Made with <i class="bi bi-heart-fill text-danger"></i> by Admin
                </div>
            </div>
        </div>
    </footer>

    {{-- CSS Tambahan untuk Responsif --}}
    <style>
        .hover-warning:hover { color: #ffc107 !important; transition: color 0.3s ease; }
        
        /* Penyesuaian Jarak Navbar di HP */
        @media (max-width: 768px) {
            .main-responsive { padding-top: 80px !important; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>