@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Integrasi Apigames (Cek ID Game)</h4>
</div>

{{-- Alert Notifikasi (Style sama dengan Digiflazz) --}}
@if(session('success'))
    <div class="alert alert-success fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fw-bold text-center border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
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
                <form action="{{ route('admin.integration.apigames.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Merchant ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" name="apigames_merchant" class="form-control" 
                                   value="{{ $merchant }}" placeholder="Contoh: M2301xxxx" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Secret Key</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="text" name="apigames_secret" class="form-control" 
                                   value="{{ $secret }}" placeholder="Masukkan Secret Key Apigames" required>
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

    {{-- KOLOM KANAN: TES KONEKSI --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Tes Koneksi</h6>
            </div>
            <div class="card-body text-center py-4">
                {{-- Ikon Besar --}}
                <i class="bi bi-hdd-network fs-1 text-secondary mb-3 d-block"></i>
                
                <p class="text-muted mb-4">
                    Klik tombol di bawah untuk mengecek apakah Merchant ID & Secret Key valid dan terhubung ke server Apigames.
                </p>
                
                <form action="{{ route('admin.integration.apigames.check') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success fw-bold px-4 py-2">
                        <i class="bi bi-broadcast me-2"></i> CEK SALDO & KONEKSI
                    </button>
                </form>
            </div>
        </div>

        {{-- Card Info/Tips --}}
        <div class="alert alert-info border-0 shadow-sm">
            <h6 class="fw-bold"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Informasi:</h6>
            <ul class="mb-0 ps-3 small">
                <li>Pastikan saldo Apigames mencukupi (Rp 50 - Rp 100 per cek).</li>
                <li>Fitur ini digunakan otomatis saat user memasukkan ID Game di halaman pembelian.</li>
                <li>Jika API Error, sistem akan otomatis menggunakan mode <em>Guest</em> (bypass) agar user tetap bisa order.</li>
            </ul>
        </div>
    </div>
</div>
@endsection