@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Integrasi Tripay (Payment Gateway)</h4>
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
                <form action="{{ route('admin.integration.tripay.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mode Environment</label>
                        <select name="mode" class="form-select bg-light border-secondary border-opacity-25">
                            <option value="production" {{ \App\Models\Configuration::getBy('tripay_mode') == 'production' ? 'selected' : '' }}>Production (Live - Uang Asli)</option>
                            <option value="sandbox" {{ \App\Models\Configuration::getBy('tripay_mode') == 'sandbox' ? 'selected' : '' }}>Sandbox (Simulasi - Uang Mainan)</option>
                        </select>
                        <div class="form-text text-danger">
                            <i class="bi bi-exclamation-circle-fill"></i> API Key Sandbox BERBEDA dengan API Key Production.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Key</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" name="api_key" class="form-control" value="{{ \App\Models\Configuration::getBy('tripay_api_key') }}" placeholder="Contoh: DEV-xxxxxxxx">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Private Key</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="private_key" class="form-control" value="{{ \App\Models\Configuration::getBy('tripay_private_key') }}" placeholder="Contoh: xxxxx-xxxxx">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Merchant Code</label>
                        <input type="text" name="merchant_code" class="form-control" value="{{ \App\Models\Configuration::getBy('tripay_merchant_code') }}" placeholder="Contoh: T12345">
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
                <i class="bi bi-credit-card-2-front fs-1 text-secondary mb-3 d-block"></i>
                <p class="text-muted mb-4">
                    Sistem akan mencoba menghubungi server Tripay untuk memvalidasi API Key Anda.
                </p>
                
                <form action="{{ route('admin.integration.tripay.check') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success fw-bold px-4 py-2">
                        <i class="bi bi-broadcast me-2"></i> CEK KONEKSI TRIPAY
                    </button>
                </form>
            </div>
        </div>

        <div class="alert alert-warning border-0 shadow-sm">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Penting:</h6>
            <p class="small mb-0">
                Jangan lupa menyetting <strong>Callback URL</strong> di dashboard Tripay Anda agar status pembayaran bisa update otomatis.
                <br>
                <strong>Callback URL Anda:</strong><br>
                <code>{{ url('/api/callback/tripay') }}</code> (Belum dibuat)
            </p>
        </div>
    </div>
</div>
@endsection