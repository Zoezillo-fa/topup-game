@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Integrasi Digiflazz (PPOB & Game)</h4>
</div>

@if(session('connection_success'))
    <div class="alert alert-success fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('connection_success') }}
    </div>
@endif

@if(session('connection_failed'))
    <div class="alert alert-danger fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('connection_failed') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-primary fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Konfigurasi API</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.integration.digiflazz.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mode Transaksi</label>
                        <select name="mode" class="form-select bg-light border-secondary border-opacity-25">
                            <option value="production" {{ \App\Models\Configuration::getBy('digiflazz_mode') == 'production' ? 'selected' : '' }}>Production (Live)</option>
                            <option value="development" {{ \App\Models\Configuration::getBy('digiflazz_mode') == 'development' ? 'selected' : '' }}>Development (Testing)</option>
                        </select>
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Gunakan 'Development' jika sedang mengetes dengan akun tester.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username Digiflazz</label>
                        <input type="text" name="username" class="form-control" value="{{ \App\Models\Configuration::getBy('digiflazz_username') }}" placeholder="Contoh: user1234">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Key (Production / Dev Key)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" name="key" class="form-control" value="{{ \App\Models\Configuration::getBy('digiflazz_key') }}" placeholder="Masukkan Secret Key">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="bi bi-save me-2"></i> SIMPAN KONFIGURASI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Tes Koneksi</h6>
            </div>
            <div class="card-body text-center py-4">
                <i class="bi bi-router fs-1 text-secondary mb-3 d-block"></i>
                <p class="text-muted mb-4">
                    Klik tombol di bawah untuk mengecek apakah Username & API Key valid dan terhubung ke server Digiflazz.
                </p>
                
                <form action="{{ route('admin.integration.digiflazz.check') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success fw-bold px-4 py-2">
                        <i class="bi bi-broadcast me-2"></i> CEK SALDO & KONEKSI
                    </button>
                </form>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm">
            <h6 class="fw-bold"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Tips:</h6>
            <ul class="mb-0 ps-3 small">
                <li>Pastikan IP Server Hosting kamu sudah didaftarkan (Whitelist) di panel Digiflazz.</li>
                <li>Saldo Development biasanya dummy (tidak nyata).</li>
            </ul>
        </div>
    </div>
</div>
@endsection