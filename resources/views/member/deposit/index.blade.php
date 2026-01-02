@extends('layouts.main')

@section('title', 'Isi Saldo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card bg-dark border-secondary shadow">
                <div class="card-header border-secondary py-3">
                    <h5 class="mb-0 text-white fw-bold"><i class="bi bi-wallet2 text-warning me-2"></i>Isi Saldo Akun</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Alert Info --}}
                    <div class="alert alert-info border-0 text-white mb-4" style="background: rgba(14, 165, 233, 0.2);">
                        <i class="bi bi-info-circle-fill me-2"></i> Metode pembayaran otomatis menggunakan <strong>QRIS</strong>. Saldo akan masuk otomatis setelah pembayaran berhasil.
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger border-0 text-white mb-4" style="background: #ef4444;">
                            <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('deposit.store') }}" method="POST" id="depositForm">
                        @csrf
                        
                        {{-- Input Nominal --}}
                        <div class="mb-4">
                            <label class="text-secondary fw-bold mb-2">Mau isi saldo berapa?</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-secondary border-secondary text-white fw-bold">Rp</span>
                                <input type="number" name="amount" id="amountInput" class="form-control bg-dark text-white border-secondary fw-bold" placeholder="Minimal 10.000" min="10000" required>
                            </div>
                        </div>

                        {{-- Pilihan Cepat --}}
                        <div class="mb-4">
                            <label class="text-secondary small mb-2">Pilihan Cepat:</label>
                            <div class="row g-2">
                                @foreach([10000, 25000, 50000, 100000, 250000, 500000] as $nom)
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-secondary w-100 btn-sm text-white" onclick="setAmount({{ $nom }})">
                                        {{ number_format($nom, 0, ',', '.') }}
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Info Pembayaran --}}
                        <div class="card bg-dark border-secondary mb-4">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="me-3">
                                    {{-- Logo QRIS --}}
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/QRIS_logo.svg/1200px-QRIS_logo.svg.png" 
                                         alt="QRIS" style="height: 30px; filter: invert(1);"> 
                                </div>
                                <div>
                                    <h6 class="text-white mb-0 fw-bold">QRIS Instant</h6>
                                    <small class="text-secondary">Scan pakai GoPay, OVO, Dana, ShopeePay, dll.</small>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-3 text-dark fs-5">
                            <i class="bi bi-qr-code-scan me-2"></i> BAYAR SEKARANG
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function setAmount(amount) {
        document.getElementById('amountInput').value = amount;
    }
</script>
@endsection