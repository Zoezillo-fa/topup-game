@extends('layouts.admin')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.products.index') }}" class="text-secondary text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
    </a>
</div>

<h4 class="fw-bold mb-4">Sync Produk Digiflazz</h4>

@if(session('error')) 
    <div class="alert alert-danger shadow-sm border-0">
        <i class="bi bi-exclamation-circle-fill me-2"></i> {!! session('error') !!}
    </div> 
@endif

<div class="row">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 fw-bold">
                Form Sinkronisasi
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.sync.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">1. Masukkan ke Game Apa?</label>
                        <select name="game_code" class="form-select" required>
                            <option value="">-- Pilih Game Lokal --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->code }}">{{ $game->name }} ({{ $game->code }})</option>
                            @endforeach
                        </select>
                        <div class="form-text">Produk yang ditarik akan dimasukkan ke kategori game ini di database Anda.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">2. Brand di Digiflazz</label>
                        <input type="text" name="provider_brand" class="form-control" placeholder="Contoh: MOBILE LEGENDS" required>
                        <div class="form-text">
                            Pastikan penulisan mirip dengan data Digiflazz. <br>
                            Contoh: <code>MOBILE LEGENDS</code>, <code>FREE FIRE</code>, <code>PUBG MOBILE</code>.
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold">3. Atur Keuntungan (Margin)</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="small text-muted">Tipe Margin</label>
                                <select name="profit_type" class="form-select bg-light">
                                    <option value="percent">Persentase (%)</option>
                                    <option value="flat">Nominal Tetap (Rp)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted">Nilai</label>
                                <input type="number" name="profit_value" class="form-control" placeholder="Contoh: 10 atau 2000" required>
                            </div>
                        </div>
                        <div class="alert alert-info mt-2 small mb-0 border-0 bg-light text-dark">
                            <strong>Rumus Harga Jual:</strong><br>
                            Jika <strong>Persen (10)</strong>: Harga Modal + 10%<br>
                            Jika <strong>Nominal (2000)</strong>: Harga Modal + Rp 2.000
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        <i class="bi bi-cloud-download me-2"></i> TARIK & UPDATE PRODUK
                    </button>

                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card bg-dark text-white border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold text-warning"><i class="bi bi-info-circle-fill me-2"></i>Panduan Brand</h5>
                <p class="small text-white-50">Gunakan nama brand berikut untuk menarik data dari Digiflazz (Daftar ini hanya contoh, bisa berubah sewaktu-waktu):</p>
                <ul class="small mb-0 list-unstyled" style="column-count: 1;">
                    <li class="mb-1"><code>MOBILE LEGENDS</code></li>
                    <li class="mb-1"><code>FREE FIRE</code></li>
                    <li class="mb-1"><code>PUBG MOBILE</code></li>
                    <li class="mb-1"><code>GENSHIN IMPACT</code></li>
                    <li class="mb-1"><code>VALORANT</code></li>
                    <li class="mb-1"><code>HIGGS DOMINO</code></li>
                    <li class="mb-1"><code>ARENA OF VALOR</code></li>
                    <li class="mb-1"><code>CALL OF DUTY MOBILE</code></li>
                    <li class="mb-1"><code>POINT BLANK</code></li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-warning border-0 shadow-sm mt-3">
            <i class="bi bi-lightning-fill me-2"></i> <strong>Tips Cepat:</strong><br>
            Jangan menekan tombol "Tarik" berkali-kali dalam waktu singkat. Digiflazz mungkin memblokir sementara jika request terlalu sering (Rate Limit).
        </div>
    </div>
</div>
@endsection