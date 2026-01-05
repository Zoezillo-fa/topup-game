@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Integrasi Midtrans</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Konfigurasi API</h6>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.integration.midtrans.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-uppercase small">Mode Environment</label>
                            <select name="midtrans_mode" class="form-select @error('midtrans_mode') is-invalid @enderror">
                                <option value="sandbox" {{ ($config['midtrans_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (Development / Testing)</option>
                                <option value="production" {{ ($config['midtrans_mode'] ?? '') == 'production' ? 'selected' : '' }}>Production (Live)</option>
                            </select>
                            @error('midtrans_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-uppercase small">Server Key</label>
                            <input type="text" name="midtrans_server_key" class="form-control @error('midtrans_server_key') is-invalid @enderror" 
                                value="{{ $config['midtrans_server_key'] ?? '' }}" placeholder="SB-Mid-server-..." required>
                            <div class="form-text small text-muted">
                                Kunci rahasia untuk transaksi di backend. Jangan bagikan key ini ke publik.
                            </div>
                            @error('midtrans_server_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-uppercase small">Client Key</label>
                            <input type="text" name="midtrans_client_key" class="form-control @error('midtrans_client_key') is-invalid @enderror" 
                                value="{{ $config['midtrans_client_key'] ?? '' }}" placeholder="SB-Mid-client-..." required>
                            <div class="form-text small text-muted">
                                Kunci publik untuk memanggil Popup Pembayaran (Snap) di frontend.
                            </div>
                            @error('midtrans_client_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-info-circle me-2"></i>Informasi Callback</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Agar status pembayaran otomatis terupdate (Lunas/Expired), Anda wajib memasukkan URL di bawah ini ke dashboard Midtrans.
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Notification URL</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-light small" id="callbackUrl" value="{{ url('/api/callback/midtrans') }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-warning small">
                        <strong>Cara Setting:</strong><br>
                        1. Login ke Dashboard Midtrans.<br>
                        2. Masuk menu <em>Settings</em> > <em>Configuration</em>.<br>
                        3. Paste URL di atas ke kolom <strong>Notification URL</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("callbackUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Untuk mobile device
        navigator.clipboard.writeText(copyText.value);
        alert("URL Callback berhasil disalin!");
    }
</script>
@endsection