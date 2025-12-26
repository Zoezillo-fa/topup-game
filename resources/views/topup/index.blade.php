@extends('layouts.main')

@section('title', 'Top Up ' . $game->name)

@section('content')
<div class="container pb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="position-relative rounded-4 shadow-lg overflow-hidden border border-secondary border-opacity-25">
                <img src="{{ $game->banner }}" class="w-100" style="height: 300px; object-fit: cover; filter: brightness(0.7);" alt="Banner {{ $game->name }}">
                
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
                            "Prosesnya cepet banget, hitungan detik langsung masuk. Admin juga fast respon!"
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-white fw-bold">- Player (Top Global)</small>
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-8">
            
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-lg mb-4 text-white" style="background-color: #ef4444;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-lg mb-4 text-white" style="background-color: #10b981;">
                    <i class="bi bi-check-circle-fill me-2"></i> {!! session('success') !!}
                </div>
            @endif

            <form action="{{ route('topup.process') }}" method="POST">
                @csrf
                <input type="hidden" name="game_code" id="game_code" value="{{ $game->target_endpoint }}"> <input type="hidden" name="nickname_game" id="nickname_game">

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
                                <input type="number" class="form-control form-dark" id="userid" name="user_id" placeholder="Contoh: 12345678" required>
                            </div>
                            
                            @if(str_contains(strtolower($game->code), 'mobile-legend'))
                            <div class="col-4 col-md-4">
                                <label class="small text-white-50 mb-1">Zone ID</label>
                                <input type="number" class="form-control form-dark" id="zoneid" name="zone_id" placeholder="1234">
                            </div>
                            @endif
                            
                            <div class="col d-flex align-items-end">
                                <button type="button" onclick="cekNamaGame()" class="btn btn-warning w-100 fw-bold text-dark shadow-warning" title="Cek Nickname">
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
                            <span class="badge bg-warning text-dark rounded-circle me-2">3</span> Kode Promo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary border-opacity-25 text-gold">
                                <i class="bi bi-ticket-perforated-fill"></i>
                            </span>
                            <input type="text" name="promo_code" class="form-control form-dark" placeholder="Masukkan kode voucher (Opsional)">
                        </div>
                        <div class="form-text text-white-50 small mt-2">
                            <i class="bi bi-info-circle me-1"></i> Harga otomatis terpotong jika kode valid.
                        </div>
                    </div>
                </div>

                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0">
                            <span class="badge bg-warning text-dark rounded-circle me-2">4</span> Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="paymentAccordion">
                            
                            @if(isset($paymentChannels['e_wallet']) && count($paymentChannels['e_wallet']) > 0)
                            <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent text-white shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-ewallet">
                                        <i class="bi bi-wallet2 text-warning me-2"></i> E-Wallet & QRIS
                                    </button>
                                </h2>
                                <div id="flush-ewallet" class="accordion-collapse collapse show" data-bs-parent="#paymentAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            @foreach($paymentChannels['e_wallet'] as $pay)
                                                <div class="col-6 col-md-4">
                                                    <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $pay->code }}" value="{{ $pay->code }}" required>
                                                    <label class="btn btn-outline-light w-100 h-100 d-flex flex-column align-items-center justify-content-center py-2 payment-card position-relative" for="pay_{{ $pay->code }}">
                                                        <img src="{{ $pay->image }}" height="25" class="mb-2 bg-white rounded px-1" alt="{{ $pay->name }}" style="max-width: 80%;">
                                                        <span class="small fw-bold text-white-50 text-center">{{ $pay->name }}</span>
                                                        <div class="check-mark-pay">
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($paymentChannels['virtual_account']) && count($paymentChannels['virtual_account']) > 0)
                            <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-transparent text-white shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-va">
                                        <i class="bi bi-bank text-info me-2"></i> Virtual Account
                                    </button>
                                </h2>
                                <div id="flush-va" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            @foreach($paymentChannels['virtual_account'] as $pay)
                                                <div class="col-6 col-md-4">
                                                    <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $pay->code }}" value="{{ $pay->code }}" required>
                                                    <label class="btn btn-outline-light w-100 h-100 d-flex flex-column align-items-center justify-content-center py-2 payment-card position-relative" for="pay_{{ $pay->code }}">
                                                        <img src="{{ $pay->image }}" height="20" class="mb-2 bg-white rounded px-1" alt="{{ $pay->name }}" style="max-width: 80%;">
                                                        <span class="small fw-bold text-white-50 text-center">{{ $pay->name }}</span>
                                                        <div class="check-mark-pay">
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                             @if(isset($paymentChannels['retail']) && count($paymentChannels['retail']) > 0)
                             <div class="accordion-item bg-transparent">
                                 <h2 class="accordion-header">
                                     <button class="accordion-button collapsed bg-transparent text-white shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-retail">
                                         <i class="bi bi-shop text-danger me-2"></i> Minimarket
                                     </button>
                                 </h2>
                                 <div id="flush-retail" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                     <div class="accordion-body">
                                         <div class="row g-2">
                                             @foreach($paymentChannels['retail'] as $pay)
                                                 <div class="col-6 col-md-4">
                                                     <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $pay->code }}" value="{{ $pay->code }}" required>
                                                     <label class="btn btn-outline-light w-100 h-100 d-flex flex-column align-items-center justify-content-center py-2 payment-card position-relative" for="pay_{{ $pay->code }}">
                                                         <img src="{{ $pay->image }}" height="25" class="mb-2 bg-white rounded px-1" alt="{{ $pay->name }}" style="max-width: 80%;">
                                                         <span class="small fw-bold text-white-50 text-center">{{ $pay->name }}</span>
                                                         <div class="check-mark-pay">
                                                             <i class="bi bi-check-circle-fill text-success"></i>
                                                         </div>
                                                     </label>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             @endif

                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold-gradient w-100 py-3 fw-bold fs-5 rounded-pill shadow-lg hover-scale text-dark mb-5 border-0">
                    <i class="bi bi-cart-check-fill me-2"></i> KONFIRMASI TOP UP
                </button>

                <div class="card bg-card-dark border-0 shadow-lg">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bolder text-gradient-gold mb-3">Tentang {{ $game->name }}</h4>
                        <p class="text-light-muted mb-4" style="line-height: 1.8;">
                            Beli Diamond {{ $game->name }} termurah dan terpercaya hanya di <strong>Store Game</strong>. 
                            Kami menjamin keamanan transaksi 100% dengan proses instan tanpa ribet.
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
            url: '/api/check-game-id', // Pastikan route ini ada
            type: 'POST',
            data: { 
                user_id: userId, 
                zone_id: zoneId, 
                game_code: gameCode,
                _token: '{{ csrf_token() }}'
            },
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
                $('#nick-result').attr('class', 'text-danger fw-bold');
                $('#nick-result').html('Gagal koneksi server.');
            }
        });
    }
</script>
<style>
    /* CSS VARIABLE */
    :root {
        --card-bg: #1e212b;
        --border-color: rgba(255, 255, 255, 0.1);
        --gold-text: #facc15;
    }

    /* CARD STYLE */
    .bg-card-dark {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }

    /* TEXT STYLE */
    .text-light-muted { color: #d1d5db !important; }
    .text-gold {
        color: var(--gold-text);
        text-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
    }
    .text-gradient-gold {
        background: linear-gradient(to right, #facc15, #b45309);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* FORM STYLE */
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

    /* PRODUCT CARD */
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
    
    /* PRODUCT SELECTED */
    .btn-check:checked + .product-card {
        background-color: rgba(250, 204, 21, 0.1);
        border: 1px solid var(--gold-text);
        box-shadow: 0 0 15px rgba(250, 204, 21, 0.2);
    }
    
    /* CHECK MARK ANIMATION */
    .check-mark, .check-mark-pay {
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

    /* PAYMENT SECTION STYLES */
    .accordion-button::after { filter: invert(1); }
    .accordion-button:not(.collapsed) {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--gold-text);
        box-shadow: none;
    }
    
    .payment-card {
        background-color: #1a1d26;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        transition: all 0.2s;
        opacity: 0.8;
    }
    .payment-card:hover {
        background-color: #252a36;
        border-color: rgba(255, 255, 255, 0.3);
        opacity: 1;
    }
    .btn-check:checked + .payment-card {
        background-color: rgba(16, 185, 129, 0.1); /* Hijau Tipis */
        border: 1px solid #10b981; /* Hijau Sukses */
        opacity: 1;
    }
    .btn-check:checked + .payment-card .check-mark-pay {
        opacity: 1;
        transform: scale(1);
    }

    /* BUTTONS */
    .btn-gold-gradient {
        background: linear-gradient(45deg, #facc15, #fbbf24);
        border: none;
        color: #1a1a1a;
    }
    .shadow-warning { box-shadow: 0 4px 14px 0 rgba(250, 204, 21, 0.39); }
    .hover-scale:hover { transform: scale(1.02); }

    /* UTILS */
    .glow-on-hover { transition: box-shadow 0.3s ease; }
    .glow-on-hover:hover { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important; }

</style>
@endsection