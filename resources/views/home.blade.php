@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
<div class="container">
    
    {{-- CAROUSEL BANNER --}}
    <div id="heroCarousel" class="carousel slide rounded-4 overflow-hidden shadow-lg mb-4 mb-md-5" data-bs-ride="carousel">
        
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            
            <div class="carousel-item active">
                {{-- Class 'banner-hero' mengatur tinggi gambar secara responsif --}}
                <img src="{{ asset('images/home/banner1.jpg') }}" class="d-block w-100 banner-hero" alt="Banner 1">
                <div class="carousel-caption text-start" style="bottom: 20%; left: 8%;">
                    <h1 class="fw-bolder display-5 text-white">TOP UP <span style="color: var(--gold-color);">KILAT</span></h1>
                    <p class="lead text-white-50">Layanan otomatis 24 Jam.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('images/home/banner2.jpg') }}" class="d-block w-100 banner-hero" alt="Banner 2">
                <div class="carousel-caption text-start" style="bottom: 20%; left: 8%;">
                    <h1 class="fw-bolder display-5 text-white">HARGA <span class="text-warning">TERMURAH</span></h1>
                    <p class="lead text-white-50">Aman, Legal, dan Terpercaya.</p>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    {{-- HEADER JUDUL & SEARCH (RESPONSIF) --}}
    <div class="row align-items-center mb-4">
        {{-- Di HP full width (col-12), di Desktop 8 kolom --}}
        <div class="col-12 col-md-8 mb-3 mb-md-0">
            <h3 class="section-title-premium text-uppercase mb-0">
                <i class="bi bi-controller text-warning me-2"></i>Daftar Game
            </h3>
        </div>
        {{-- Di HP full width (col-12), di Desktop 4 kolom --}}
        <div class="col-12 col-md-4">
            <div class="search-container-premium d-flex align-items-center">
                <i class="bi bi-search text-secondary me-3"></i>
                <input type="text" id="searchInput" class="search-input-premium" placeholder="Cari game...">
            </div>
        </div>
    </div>

    {{-- LIST GAME --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4" id="gameContainer">
        @forelse($games as $game)
        <div class="col game-item">
            <a href="{{ route('topup.index', $game->slug) }}" class="text-decoration-none text-white">
                <div class="card-game-premium h-100">
                    <div style="position: relative;">
                        <img src="{{ $game->banner ? asset($game->banner) : asset('images/no-banner.jpg') }}" 
                             class="banner-img" 
                             alt="{{ $game->name }}"
                             onerror="this.src='{{ asset('images/no-banner.jpg') }}'">
                        
                        <img src="{{ $game->thumbnail ? asset($game->thumbnail) : asset('images/no-logo.png') }}" 
                             class="logo-floating" 
                             alt="Logo"
                             onerror="this.src='{{ asset('images/no-logo.png') }}'">
                    </div>
                    <div class="card-body">
                        <div class="game-title-premium name-game">{{ $game->name }}</div>
                        <div class="game-publisher-premium">{{ $game->publisher ?? 'Official' }}</div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-joystick fs-1 mb-3 text-secondary"></i>
                <p>Belum ada game.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- CSS KHUSUS HALAMAN INI --}}
<style>
    /* Default Desktop */
    .banner-hero {
        height: 350px;
        object-fit: cover;
        filter: brightness(0.7);
    }

    /* Mobile Responsive (Layar < 768px) */
    @media (max-width: 768px) {
        .banner-hero {
            height: 180px !important; /* Banner lebih kecil di HP */
        }
        /* Perkecil font judul di HP */
        .carousel-caption h1 {
            font-size: 1.5rem; 
        }
        .carousel-caption p {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Script Search Game
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let games = document.getElementsByClassName('game-item');
        for (let i = 0; i < games.length; i++) {
            let title = games[i].querySelector('.name-game').textContent;
            games[i].style.display = title.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    });
</script>
@endsection