@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Integrasi Xendit (Payment Gateway)</h4>
</div>

{{-- NOTIFIKASI --}}
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

@if(session('error'))
    <div class="alert alert-danger fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ session('error') }}
    </div>
@endif

<div class="row">
    {{-- KOLOM KIRI: KONFIGURASI --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Konfigurasi API</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.integration.xendit.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mode Environment</label>
                        <select name="xendit_mode" class="form-select bg-light border-secondary border-opacity-25">
                            <option value="production" {{ \App\Models\Configuration::getBy('xendit_mode') == 'production' ? 'selected' : '' }}>Production (Live - Uang Asli)</option>
                            <option value="sandbox" {{ \App\Models\Configuration::getBy('xendit_mode') == 'sandbox' ? 'selected' : '' }}>Sandbox (Simulasi - Uang Mainan)</option>
                        </select>
                        <div class="form-text text-danger">
                            <i class="bi bi-exclamation-circle-fill"></i> Secret Key Sandbox & Production itu berbeda.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Secret Key</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" name="xendit_secret_key" class="form-control" value="{{ \App\Models\Configuration::getBy('xendit_secret_key') }}" placeholder="Contoh: xnd_production_...">
                        </div>
                        <div class="form-text text-muted small">
                            Didapatkan dari Dashboard Xendit > Settings > API Keys.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Callback Verification Token</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="text" name="xendit_callback_token" class="form-control" value="{{ \App\Models\Configuration::getBy('xendit_callback_token') }}" placeholder="Opsional (Untuk Keamanan)">
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

    {{-- KOLOM KANAN: TES KONEKSI & INFO --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Tes Koneksi</h6>
            </div>
            <div class="card-body text-center py-4">
                {{-- Icon Besar Seperti Tripay/Digiflazz --}}
                <i class="bi bi-shield-check fs-1 text-secondary mb-3 d-block"></i>
                
                <p class="text-muted mb-4">
                    Sistem akan mencoba menghubungi server Xendit untuk memvalidasi Secret Key dan mengecek saldo akun Anda.
                </p>
                
                <form action="{{ route('admin.integration.xendit.check') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success fw-bold px-4 py-2">
                        <i class="bi bi-broadcast me-2"></i> CEK KONEKSI XENDIT
                    </button>
                </form>
            </div>
        </div>

        <div class="alert alert-warning border-0 shadow-sm">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Penting:</h6>
            <p class="small mb-0">
                Agar status pembayaran otomatis berubah menjadi <strong>PAID</strong>, pasang URL di bawah ini pada Dashboard Xendit (Menu: Settings > Callbacks).
                <br><br>
                <strong>Callback URL Anda:</strong><br>
                <div class="input-group input-group-sm mt-1">
                    <input type="text" class="form-control bg-white" value="{{ url('/api/callback/xendit') }}" readonly id="cbUrl">
                    <button class="btn btn-secondary" type="button" onclick="copyCb()"><i class="bi bi-clipboard"></i></button>
                </div>
            </p>
        </div>
    </div>
</div>

<script>
    function copyCb() {
        var copyText = document.getElementById("cbUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("URL Callback berhasil disalin!");
    }
</script>
@endsection