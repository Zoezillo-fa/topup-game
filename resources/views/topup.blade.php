@extends('layouts.main')

@section('title', 'Top Up ' . $game->name)

@section('content')
<div class="container pb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="position-relative rounded-4 shadow-lg overflow-hidden border border-secondary border-opacity-25">
                <img src="{{ $game->banner }}" class="w-100" style="height: 300px; object-fit: cover; filter: brightness(0.7);" alt="Banner">
                
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(15,17,25, 0.95), transparent);">
                    <div class="d-flex align-items-end">
                        <img src="{{ $game->thumbnail }}" class="rounded-3 shadow-lg border border-warning me-3 d-none d-md-block" width="90" alt="Logo">
                        <div>
                            <h1 class="fw-bolder text-white mb-0 text-uppercase" style="text-shadow: 0 2px 10px rgba(0,0,0,0.5);">{{ $game->name }}</h1>
                            <p class="text-warning mb-0 fw-bold"><i class="bi bi-patch-check-fill me-1"></i> {{ $game->publisher }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="sticky-top" style="top: 120px; z-index: 1;">
                
                <div class="card bg-card-dark border-0 shadow-lg mb-3 overflow-hidden">
                    <div class="card-body position-relative">
                        <div class="position-absolute top-0 end-0 p-3 opacity-10">
                            <i class="bi bi-controller fs-1 text-white"></i>
                        </div>
                        
                        <h5 class="fw-bold text-white mb-3"><i class="bi bi-info-circle text-warning me-2"></i>Informasi</h5>
                        <ul class="list-unstyled mb-0 text-light small">
                            <li class="d-flex justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                <span class="text-white-50">Publisher</span>
                                <span class="fw-bold text-white">{{ $game->publisher }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                <span class="text-white-50">Sistem</span>
                                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25">Otomatis</span>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span class="text-white-50">Layanan</span>
                                <span class="fw-bold text-warning">24 Jam Non-Stop</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card bg-card-dark border-0 shadow-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-chat-quote-fill text-warning fs-3 me-2"></i>
                            <h6 class="fw-bold text-white mb-0">Ulasan Pembeli</h6>
                        </div>
                        <p class="small text-white-50 fst-italic mb-3">
                            "Gila sih, detik ini bayar detik ini juga masuk diamond-nya. Recommended parah!"
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-white fw-bold">- Rian (Top Global)</small>
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-8">
            <form action="{{ route('topup.process') }}" method="POST">
                @csrf
                <input type="hidden" name="game_code" id="game_code" value="{{ $game->target_endpoint }}">
                <input type="hidden" name="nickname_game" id="nickname_game">

                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0">
                            <span class="badge bg-warning text-dark rounded-circle me-2">1</span> Masukkan ID Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6 col-md-6">
                                <label class="small text-white-50 mb-1">User ID</label>
                                <input type="number" class="form-control form-dark" id="userid" name="userid" placeholder="Contoh: 12345678" required>
                            </div>
                            @if($game->code == 'mobile-legends')
                            <div class="col-4 col-md-4">
                                <label class="small text-white-50 mb-1">Zone ID</label>
                                <input type="number" class="form-control form-dark" id="zoneid" name="zoneid" placeholder="1234">
                            </div>
                            @endif
                            <div class="col d-flex align-items-end">
                                <button type="button" onclick="cekNamaGame()" class="btn btn-warning w-100 fw-bold text-dark shadow-warning">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 text-end">
                            <small class="text-info fw-bold" id="nick-result"></small>
                        </div>
                    </div>
                </div>

                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0">
                            <span class="badge bg-warning text-dark rounded-circle me-2">2</span> Pilih Item
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @foreach($products as $product)
                            <div class="col">
                                <input type="radio" class="btn-check" name="product_code" id="prod{{ $product->id }}" value="{{ $product->code }}" required>
                                <label class="btn btn-outline-light w-100 h-100 d-flex flex-column justify-content-center py-3 product-card position-relative" for="prod{{ $product->id }}">
                                    <span class="fw-bold d-block mb-1 text-white">{{ $product->name }}</span>
                                    <span class="text-gold fw-bolder">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    
                                    <div class="check-mark">
                                        <i class="bi bi-check-circle-fill text-warning"></i>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0">
                            <span class="badge bg-warning text-dark rounded-circle me-2">3</span> Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="payment-box p-3 rounded-3 border border-secondary border-opacity-25 d-flex align-items-center">
                            <div class="bg-white p-2 rounded me-3 shadow-sm">
                                <i class="bi bi-qr-code-scan fs-2 text-dark"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-white mb-0">QRIS All Payment</h6>
                                <small class="text-white-50">Support: GoPay, OVO, Dana, ShopeePay, BCA, dll.</small>
                            </div>
                            <div class="ms-auto">
                                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25">Otomatis</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold-gradient w-100 py-3 fw-bold fs-5 rounded-pill shadow-lg hover-scale text-dark mb-5 border-0">
                    <i class="bi bi-cart-check-fill me-2"></i> KONFIRMASI TOP UP
                </button>

                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card bg-card-dark border-0 shadow-lg">
                            <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                                <h6 class="fw-bold text-white mb-0"><i class="bi bi-question-circle-fill text-warning me-2"></i>Cara Top Up</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush list-group-dark">
                                    <li class="list-group-item bg-transparent text-light border-secondary border-opacity-10">
                                        <span class="text-warning fw-bold me-2">1.</span> Masukkan <strong>User ID</strong> Anda.
                                    </li>
                                    <li class="list-group-item bg-transparent text-light border-secondary border-opacity-10">
                                        <span class="text-warning fw-bold me-2">2.</span> Pilih produk <strong>Diamonds</strong> yang diinginkan.
                                    </li>
                                    <li class="list-group-item bg-transparent text-light border-secondary border-opacity-10">
                                        <span class="text-warning fw-bold me-2">3.</span> Selesaikan pembayaran via QRIS.
                                    </li>
                                    <li class="list-group-item bg-transparent text-light border-secondary border-opacity-10">
                                        <span class="text-warning fw-bold me-2">4.</span> Saldo akan masuk otomatis dalam 1-3 detik.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card bg-card-dark border-0 shadow-lg">
                            <div class="card-body p-4 text-center">
                                <h4 class="fw-bolder text-gradient-gold mb-3">Tentang {{ $game->name }}</h4>
                                <p class="text-light-muted mb-4" style="line-height: 1.8;">
                                    Beli Diamond {{ $game->name }} termurah dan terpercaya hanya di <strong>Store Game</strong>. 
                                    Kami menjamin keamanan transaksi 100% dengan proses instan tanpa ribet. 
                                    Tingkatkan pengalaman bermainmu dengan skin-skin epik terbaru sekarang juga!
                                </p>
                                <div class="row justify-content-center g-3">
                                    <div class="col-4">
                                        <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25">
                                            <h3 class="fw-bold text-success mb-0">100%</h3>
                                            <small class="text-white-50">Legal</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25">
                                            <h3 class="fw-bold text-warning mb-0">24 Jam</h3>
                                            <small class="text-white-50">Support</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25">
                                            <h3 class="fw-bold text-info mb-0">1 Detik</h3>
                                            <small class="text-white-50">Proses</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function cekNamaGame() {
        var userId = $('#userid').val();
        var zoneId = $('#zoneid').val();
        var gameCode = $('#game_code').val();

        if(userId == '') {
            alert("Harap isi User ID terlebih dahulu!");
            $('#userid').focus();
            return;
        }

        $('#nick-result').html('<span class="spinner-border spinner-border-sm me-2"></span> Checking...');

        $.ajax({
            url: '/api/check-game-id',
            type: 'POST',
            data: { user_id: userId, zone_id: zoneId, game_code: gameCode },
            success: function(res) {
                if(res.status == 'success') {
                    $('#nick-result').attr('class', 'text-success fw-bold');
                    $('#nick-result').html('<i class="bi bi-check-circle-fill me-1"></i> ' + res.nick_name);
                    $('#nickname_game').val(res.nick_name);
                } else {
                    $('#nick-result').attr('class', 'text-danger fw-bold');
                    $('#nick-result').html('<i class="bi bi-x-circle-fill me-1"></i> ID Salah / Tidak Ditemukan');
                    $('#nickname_game').val('');
                }
            },
            error: function() {
                $('#nick-result').html('Server Error.');
            }
        });
    }
</script>
<style>
    /* VARS */
    :root {
        --card-bg: #1e212b; /* Lebih gelap sedikit dari bg utama */
        --border-color: rgba(255, 255, 255, 0.1);
        --gold-text: #facc15;
    }

    /* CARD STYLES */
    .bg-card-dark {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }

    /* TEXT COLORS - SOLUSI MASALAH TERBACA */
    .text-light-muted {
        color: #d1d5db !important; /* Abu-abu terang, JAUH LEBIH TERBACA dibanding text-muted */
    }
    .text-gold {
        color: var(--gold-text);
        text-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
    }
    .text-gradient-gold {
        background: linear-gradient(to right, #facc15, #b45309);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* FORM INPUTS */
    .form-dark {
        background-color: #111319;
        border: 1px solid var(--border-color);
        color: white;
        padding: 12px;
        border-radius: 10px;
    }
    .form-dark:focus {
        background-color: #0b0d11;
        border-color: var(--gold-text);
        color: white;
        box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.1);
    }
    .form-dark::placeholder { color: #6b7280; }

    /* PRODUCT CARD SELECTION */
    .product-card {
        background-color: #262a36;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.3);
        background-color: #2d3240;
    }
    
    /* Saat dipilih */
    .btn-check:checked + .product-card {
        background-color: rgba(250, 204, 21, 0.1);
        border: 1px solid var(--gold-text);
        box-shadow: 0 0 15px rgba(250, 204, 21, 0.2);
    }
    
    /* Check Mark Icon Animation */
    .check-mark {
        position: absolute;
        top: 8px;
        right: 8px;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-check:checked + .product-card .check-mark {
        opacity: 1;
        transform: scale(1);
    }

    /* BUTTONS */
    .shadow-warning { box-shadow: 0 4px 14px 0 rgba(250, 204, 21, 0.39); }
    .hover-scale:hover { transform: scale(1.02); }

    /* GLOW ON HOVER */
    .glow-on-hover { transition: box-shadow 0.3s ease; }
    .glow-on-hover:hover { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important; }

</style>
@endsection