@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Konfigurasi Server</h4>
</div>

@if(session('success'))
    <div class="alert alert-success fw-bold text-center border-0 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fw-bold text-center border-0 shadow-sm mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
@endif

<div class="row g-4">
    
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-primary text-white py-3 fw-bold">
                <i class="bi bi-hdd-network-fill me-2"></i> Informasi IP Address
            </div>
            <div class="card-body">
                
                <div class="alert alert-warning d-flex align-items-start shadow-sm border-0 mb-4">
                    <i class="bi bi-exclamation-circle-fill fs-4 me-3 mt-1"></i>
                    <div>
                        <strong>PENTING UNTUK DIGIFLAZZ / TRIPAY:</strong><br>
                        Gunakan <strong>IP Public</strong> di bawah ini untuk didaftarkan ke menu <em>IP Whitelist</em> di dashboard supplier/payment gateway Anda.
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item py-3 bg-light border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-primary fw-bold">IP Public (Internet)</span>
                            <span class="badge bg-primary">Wajib Whitelist</span>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <code class="fs-4 fw-bold text-dark me-2 border rounded px-2 bg-white" id="ipText">{{ $serverInfo['ip_address'] }}</code>
                            <button class="btn btn-sm btn-outline-primary" onclick="copyIp()">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            *Jika Anda menggunakan WiFi/Tethering, IP ini bisa berubah saat restart modem/HP.
                        </small>
                    </li>

                    <li class="list-group-item d-flex justify-content-between py-3">
                        <span class="text-secondary small">IP Local (Internal)</span>
                        <span class="text-muted small font-monospace">{{ $serverInfo['local_ip'] }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between py-2">
                        <span class="text-secondary small">Versi PHP</span>
                        <span class="fw-bold small">v{{ $serverInfo['php_version'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2">
                        <span class="text-secondary small">Versi Laravel</span>
                        <span class="fw-bold small">v{{ $serverInfo['laravel_version'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2">
                        <span class="text-secondary small">Waktu Server</span>
                        <span class="small text-muted">{{ $serverInfo['server_time'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white py-3 fw-bold">
                <i class="bi bi-tools me-2"></i> Perawatan Sistem
            </div>
            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom">
                    <div>
                        <h6 class="fw-bold mb-1"><i class="bi bi-eraser-fill text-danger me-2"></i>Bersihkan Cache</h6>
                        <small class="text-muted">Klik ini jika update gambar/config tidak berubah di website.</small>
                    </div>
                    <form action="{{ route('admin.server.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger fw-bold btn-sm">
                            <i class="bi bi-trash"></i> Clear Cache
                        </button>
                    </form>
                </div>

                <div>
                    <h6 class="fw-bold mb-2"><i class="bi bi-shop-window text-warning me-2"></i>Mode Maintenance (Tutup Toko)</h6>
                    <small class="text-muted d-block mb-3">
                        Jika aktif, website hanya bisa diakses oleh Admin. Member akan melihat halaman "Sedang Perbaikan".
                    </small>
                    
                    <form action="{{ route('admin.server.maintenance') }}" method="POST">
                        @csrf
                        @if($maintenanceMode)
                            <input type="hidden" name="status" value="0">
                            <div class="alert alert-warning text-center fw-bold mb-2">
                                <i class="bi bi-cone-striped me-2"></i> STATUS: SEDANG MAINTENANCE
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                <i class="bi bi-play-circle-fill me-2"></i> AKTIFKAN WEBSITE (ONLINE)
                            </button>
                        @else
                            <input type="hidden" name="status" value="1">
                            <div class="alert alert-success text-center fw-bold mb-2">
                                <i class="bi bi-check-circle-fill me-2"></i> STATUS: WEBSITE ONLINE
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow-sm text-dark">
                                <i class="bi bi-pause-circle-fill me-2"></i> AKTIFKAN MAINTENANCE
                            </button>
                        @endif
                    </form>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body small text-muted">
                <i class="bi bi-hdd-fill me-2"></i> <strong>Software Server:</strong><br>
                <span class="font-monospace">{{ $serverInfo['server_software'] }}</span>
            </div>
        </div>
    </div>
</div>

<script>
    function copyIp() {
        var ipText = document.getElementById("ipText").innerText;
        navigator.clipboard.writeText(ipText).then(function() {
            alert("IP Address berhasil disalin: " + ipText);
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endsection