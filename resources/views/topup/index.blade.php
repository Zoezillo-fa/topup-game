@extends('layouts.main')

@section('title', 'Top Up ' . $game->name)

@section('content')
<div class="container pb-5">
    
    {{-- Banner Game --}}
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
        {{-- Sidebar Info --}}
        <div class="col-md-4 mb-4">
            <div class="sticky-top" style="top: 120px; z-index: 1;">
                <div class="card bg-card-dark border-0 shadow-lg mb-3 overflow-hidden">
                    <div class="card-body position-relative">
                        <div class="position-absolute top-0 end-0 p-3 opacity-10"><i class="bi bi-controller fs-1 text-white"></i></div>
                        <h5 class="fw-bold text-white mb-3"><i class="bi bi-info-circle text-warning me-2"></i>Informasi</h5>
                        <ul class="list-unstyled mb-0 text-light small">
                            <li class="d-flex justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                <span class="text-white-50">Publisher</span><span class="fw-bold text-white">{{ $game->publisher }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                <span class="text-white-50">Sistem</span><span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25">Otomatis</span>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span class="text-white-50">Layanan</span><span class="fw-bold text-warning">24 Jam Non-Stop</span>
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
                        <p class="small text-white-50 fst-italic mb-3">"Prosesnya cepet banget, hitungan detik langsung masuk. Admin juga fast respon!"</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-white fw-bold">- Player (Top Global)</small>
                            <div class="text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Order --}}
        <div class="col-md-8">
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-lg mb-4 text-white" style="background-color: #ef4444;"><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-lg mb-4 text-white" style="background-color: #10b981;"><i class="bi bi-check-circle-fill me-2"></i> {!! session('success') !!}</div>
            @endif

            <form id="form-topup" action="{{ route('topup.process') }}" method="POST">
                @csrf
                <input type="hidden" name="game_code" id="game_code" value="{{ $game->slug }}"> 
                <input type="hidden" name="nickname_game" id="nickname_game">

                {{-- Card 1: ID Game --}}
                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0"><span class="badge bg-warning text-dark rounded-circle me-2">1</span> Masukkan ID Akun</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6 col-md-6">
                                <label class="small text-white-50 mb-1">User ID</label>
                                <input type="number" class="form-control form-dark" id="userid" name="user_id" placeholder="Contoh: 12345678" required>
                            </div>
                            @if(str_contains(strtolower($game->slug), 'mobile-legends'))
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
                            <small class="fw-bold" id="nick-result"></small>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Pilih Item --}}
                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0"><span class="badge bg-warning text-dark rounded-circle me-2">2</span> Pilih Item</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @foreach($products as $product)
                            <div class="col">
                                <input type="radio" class="btn-check" name="product_code" id="prod{{ $product->id }}" value="{{ $product->code }}" 
                                    data-price="{{ $product->price }}" data-name="{{ $product->name }}" required>
                                <label class="btn btn-outline-light w-100 h-100 d-flex flex-column justify-content-center py-3 product-card position-relative" for="prod{{ $product->id }}">
                                    <span class="fw-bold d-block mb-1 text-white">{{ $product->name }}</span>
                                    <span class="text-gold fw-bolder">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <div class="check-mark"><i class="bi bi-check-circle-fill text-warning"></i></div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Card 3: Promo --}}
                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0"><span class="badge bg-warning text-dark rounded-circle me-2">3</span> Kode Promo</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary border-opacity-25 text-gold"><i class="bi bi-ticket-perforated-fill"></i></span>
                            <input type="text" name="promo_code" class="form-control form-dark" placeholder="Masukkan kode voucher (Opsional)">
                        </div>
                        <div class="form-text text-white-50 small mt-2"><i class="bi bi-info-circle me-1"></i> Harga otomatis terpotong jika kode valid.</div>
                    </div>
                </div>

                {{-- Card 4: Pembayaran --}}
                <div class="card bg-card-dark border-0 shadow-lg mb-4 glow-on-hover">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <h5 class="fw-bold text-white mb-0"><span class="badge bg-warning text-dark rounded-circle me-2">4</span> Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="paymentAccordion">
                            @foreach($paymentChannels as $type => $channels)
                                @if(count($channels) > 0)
                                <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-transparent text-white shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ $type }}">
                                            <i class="bi bi-wallet2 text-warning me-2"></i> {{ ucfirst(str_replace('_', ' ', $type)) }}
                                        </button>
                                    </h2>
                                    <div id="flush-{{ $type }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#paymentAccordion">
                                        <div class="accordion-body">
                                            <div class="row g-2">
                                                @foreach($channels as $pay)
                                                    <div class="col-6 col-md-4">
                                                        <input type="radio" class="btn-check" name="payment_method" id="pay_{{ $pay->code }}" value="{{ $pay->code }}" 
                                                            data-name="{{ $pay->name }}" data-fee-flat="{{ $pay->flat_fee }}" data-fee-percent="{{ $pay->percent_fee }}" required>
                                                        <label class="btn btn-outline-light w-100 h-100 d-flex flex-column align-items-center justify-content-center py-2 payment-card position-relative" for="pay_{{ $pay->code }}">
                                                            @php $imgSrc = \Illuminate\Support\Str::startsWith($pay->image, 'http') ? $pay->image : asset($pay->image); @endphp
                                                            <img src="{{ $imgSrc }}" height="25" class="mb-2 bg-white rounded px-1" alt="{{ $pay->name }}" style="max-width: 80%;">
                                                            <span class="small fw-bold text-white-50 text-center">{{ $pay->name }}</span>
                                                            <div class="check-mark-pay"><i class="bi bi-check-circle-fill text-success"></i></div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- TOMBOL BELI --}}
                <button type="button" id="btn-confirm" onclick="showConfirmModal()" class="btn btn-gold-gradient w-100 py-3 fw-bold fs-5 rounded-pill shadow-lg hover-scale text-dark mb-5 border-0">
                    <i class="bi bi-cart-check-fill me-2"></i> KONFIRMASI TOP UP
                </button>

                <div class="card bg-card-dark border-0 shadow-lg">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bolder text-gradient-gold mb-3">Tentang {{ $game->name }}</h4>
                        <p class="text-light-muted mb-4" style="line-height: 1.8;">Beli Diamond {{ $game->name }} termurah dan terpercaya hanya di <strong>Store Game</strong>. Kami menjamin keamanan transaksi 100% dengan proses instan tanpa ribet.</p>
                        <div class="row justify-content-center g-3">
                            <div class="col-4"><div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25"><h3 class="fw-bold text-success mb-0">100%</h3><small class="text-white-50">Legal</small></div></div>
                            <div class="col-4"><div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25"><h3 class="fw-bold text-warning mb-0">24 Jam</h3><small class="text-white-50">Support</small></div></div>
                            <div class="col-4"><div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25"><h3 class="fw-bold text-info mb-0">1 Detik</h3><small class="text-white-50">Proses</small></div></div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI --}}
<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirmLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color: #1e212b; border: 1px solid rgba(255,255,255,0.1); color: white;">
      <div class="modal-header border-secondary border-opacity-25">
        <h5 class="modal-title fw-bold" id="modalConfirmLabel"><i class="bi bi-receipt text-warning me-2"></i>Detail Pesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="rounded p-3 mb-3" style="background-color: #111319;">
            <div class="d-flex justify-content-between mb-1"><span class="text-white-50 small">User ID / Zone</span><span class="fw-bold" id="conf-uid">-</span></div>
            <div class="d-flex justify-content-between"><span class="text-white-50 small">Nickname</span><span class="fw-bold text-warning" id="conf-nick">-</span></div>
        </div>
        <div class="d-flex justify-content-between mb-2"><span class="text-white-50">Item</span><span class="fw-bold text-end" id="conf-item">-</span></div>
        <div class="d-flex justify-content-between mb-2"><span class="text-white-50">Metode Bayar</span><span class="fw-bold text-end" id="conf-method">-</span></div>
        <hr class="border-secondary border-opacity-25 my-3">
        <div class="d-flex justify-content-between mb-2"><span>Harga Produk</span><span class="fw-bold" id="conf-price">Rp 0</span></div>
        <div class="d-flex justify-content-between mb-2"><span>Biaya Admin</span><span class="fw-bold text-danger" id="conf-fee">Rp 0</span></div>
        <div class="d-flex justify-content-between mt-3 pt-2 border-top border-secondary border-opacity-25"><span class="fs-5 fw-bold">Total Bayar</span><span class="fs-4 fw-bolder text-warning" id="conf-total">Rp 0</span></div>
      </div>
      <div class="modal-footer border-secondary border-opacity-25">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" onclick="submitForm()" class="btn btn-gold-gradient fw-bold text-dark shadow-warning"><i class="bi bi-wallet2 me-2"></i>Lanjut Bayar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function showConfirmModal() {
        let userId = $('#userid').val();
        let zoneId = $('#zoneid').val() || '';
        let nickname = $('#nickname_game').val() || '-';
        let product = $('input[name="product_code"]:checked');
        let payment = $('input[name="payment_method"]:checked');

        if (!userId) { alert("Mohon isi User ID terlebih dahulu!"); $('#userid').focus(); return; }
        
        // VALIDASI: Wajib cek ID dulu
        if (nickname === '' || nickname === '-') {
            alert("Mohon cek ID Game Anda terlebih dahulu hingga Nickname muncul!");
            // Opsional: Bisa dipaksa cek otomatis jika lupa
            // cekNamaGame(); 
            return;
        }

        if (product.length === 0) { alert("Mohon pilih item yang ingin dibeli!"); return; }
        if (payment.length === 0) { alert("Mohon pilih metode pembayaran!"); return; }

        let price = parseFloat(product.data('price'));
        let productName = product.data('name');
        let methodName = payment.data('name');
        let feeFlat = parseFloat(payment.data('fee-flat'));
        let feePercent = parseFloat(payment.data('fee-percent'));
        let adminFee = Math.ceil(feeFlat + (price * feePercent / 100));
        let totalBayar = price + adminFee;
        let fullId = zoneId ? userId + ' (' + zoneId + ')' : userId;
        
        $('#conf-uid').text(fullId);
        $('#conf-nick').text(nickname);
        $('#conf-item').text(productName);
        $('#conf-method').text(methodName);
        $('#conf-price').text(formatRupiah(price));
        $('#conf-fee').text('+ ' + formatRupiah(adminFee));
        $('#conf-total').text(formatRupiah(totalBayar));

        var myModal = new bootstrap.Modal(document.getElementById('modalConfirm'));
        myModal.show();
    }

    function submitForm() { $('#form-topup').submit(); }

    function cekNamaGame() {
        var userId = $('#userid').val();
        var zoneId = $('#zoneid').val();
        var gameCode = $('#game_code').val();

        if(userId == '') {
            // Optional: alert("Isi ID dulu");
            return;
        }

        // TAMPILKAN LOADING
        $('#nick-result').html('<div class="d-flex align-items-center text-warning"><span class="spinner-border spinner-border-sm me-2"></span> Sedang mengecek ID...</div>');
        
        // MATIKAN TOMBOL KONFIRMASI SAAT LOADING
        $('#btn-confirm').prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-2"></span> Tunggu Sebentar...');

        $.ajax({
            url: '/api/check-game-id', 
            type: 'POST',
            data: { user_id: userId, zone_id: zoneId, game_code: gameCode, _token: '{{ csrf_token() }}' },
            success: function(res) {
                // HIDUPKAN KEMBALI TOMBOL (Default State)
                $('#btn-confirm').prop('disabled', false).html('<i class="bi bi-cart-check-fill me-2"></i> KONFIRMASI TOP UP');

                if(res.status == 'success') {
                    $('#nick-result').attr('class', 'text-success fw-bold');
                    $('#nick-result').html('<i class="bi bi-check-circle-fill me-1"></i> ' + res.nick_name);
                    $('#nickname_game').val(res.nick_name);
                } else {
                    $('#nick-result').attr('class', 'text-danger fw-bold');
                    $('#nick-result').html('<i class="bi bi-x-circle-fill me-1"></i> ' + (res.message || 'ID Salah / Tidak Ditemukan'));
                    $('#nickname_game').val('');
                    // JIKA ID SALAH, MATIKAN TOMBOL LAGI
                    $('#btn-confirm').prop('disabled', true);
                }
            },
            error: function() {
                $('#nick-result').attr('class', 'text-danger fw-bold');
                $('#nick-result').html('<i class="bi bi-wifi-off me-1"></i> Gagal koneksi server.');
                // Fallback: Izinkan user lanjut (Guest Mode)
                $('#btn-confirm').prop('disabled', false).html('<i class="bi bi-cart-check-fill me-2"></i> KONFIRMASI TOP UP');
            }
        });
    }
</script>
<style>
    :root { --card-bg: #1e212b; --border-color: rgba(255, 255, 255, 0.1); --gold-text: #facc15; }
    .bg-card-dark { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; }
    .text-light-muted { color: #d1d5db !important; }
    .text-gold { color: var(--gold-text); text-shadow: 0 0 10px rgba(250, 204, 21, 0.3); }
    .text-gradient-gold { background: linear-gradient(to right, #facc15, #b45309); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .form-dark { background-color: #111319; border: 1px solid var(--border-color); color: white; padding: 12px; border-radius: 10px; }
    .form-dark:focus { background-color: #0b0d11; border-color: var(--gold-text); color: white; box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.1); }
    .form-dark::placeholder { color: #6b7280; }
    .product-card { background-color: #262a36; border: 1px solid var(--border-color); border-radius: 12px; transition: all 0.3s ease; }
    .product-card:hover { transform: translateY(-3px); border-color: rgba(255, 255, 255, 0.3); background-color: #2d3240; }
    .btn-check:checked + .product-card { background-color: rgba(250, 204, 21, 0.1); border: 1px solid var(--gold-text); box-shadow: 0 0 15px rgba(250, 204, 21, 0.2); }
    .check-mark, .check-mark-pay { position: absolute; top: 8px; right: 8px; opacity: 0; transform: scale(0.5); transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .btn-check:checked + .product-card .check-mark { opacity: 1; transform: scale(1); }
    .accordion-button::after { filter: invert(1); }
    .accordion-button:not(.collapsed) { background-color: rgba(255, 255, 255, 0.05); color: var(--gold-text); box-shadow: none; }
    .payment-card { background-color: #1a1d26; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; transition: all 0.2s; opacity: 0.8; }
    .payment-card:hover { background-color: #252a36; border-color: rgba(255, 255, 255, 0.3); opacity: 1; }
    .btn-check:checked + .payment-card { background-color: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; opacity: 1; }
    .btn-check:checked + .payment-card .check-mark-pay { opacity: 1; transform: scale(1); }
    .btn-gold-gradient { background: linear-gradient(45deg, #facc15, #fbbf24); border: none; color: #1a1a1a; }
    /* Style tombol saat disabled */
    .btn-gold-gradient:disabled { background: #4b5563; color: #9ca3af; cursor: not-allowed; box-shadow: none; }
    .shadow-warning { box-shadow: 0 4px 14px 0 rgba(250, 204, 21, 0.39); }
    .hover-scale:hover { transform: scale(1.02); }
    .glow-on-hover { transition: box-shadow 0.3s ease; }
    .glow-on-hover:hover { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important; }
</style>
@endsection