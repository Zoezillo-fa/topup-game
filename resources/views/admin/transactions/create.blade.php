@extends('layouts.admin')

@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Transaksi Baru</h1>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-left-danger shadow-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Order Manual</h6>
        </div>
        <div class="card-body">
            
            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf
                
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="modeManual" name="is_manual_input" value="1">
                        <label class="form-check-label font-weight-bold text-dark ml-2" for="modeManual">
                            Aktifkan Mode Input SKU Manual (Bypass Database)
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 border-right">
                        <h5 class="text-gray-800 mb-3 border-bottom pb-2">1. Informasi Produk</h5>

                        <div id="section-db">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small">Pilih Kategori Game</label>
                                <select id="game_select" class="form-select">
                                    <option value="">-- Pilih Game --</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->code }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small">Pilih Item/Produk</label>
                                <select name="product_code" id="product_select" class="form-select bg-light">
                                    <option value="">-- Pilih Game Terlebih Dahulu --</option>
                                </select>
                            </div>
                        </div>

                        <div id="section-manual" style="display: none;">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small text-danger">Buyer SKU Code (Digiflazz)</label>
                                <input type="text" name="manual_sku" class="form-control border-left-danger" placeholder="Contoh: ML-5, FF-100">
                                <small class="text-muted">Wajib sama persis dengan kode di Digiflazz.</small>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small">Nama Produk (Label)</label>
                                <input type="text" name="manual_name" class="form-control" placeholder="Contoh: 5 Diamonds (Manual)">
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold small">Harga Tagihan (Rp)</label>
                                <input type="number" name="manual_price" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-gray-800 mb-3 border-bottom pb-2">2. Data Tujuan</h5>
                        
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Pilih Member (Opsional)</label>
                            <select name="user_id" class="form-select">
                                <option value="">-- Pembeli Tamu (Guest) --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">User ID / No. Tujuan</label>
                            <input type="text" name="user_id_game" class="form-control" placeholder="Contoh: 12345678 (1234)" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Status Pembayaran</label>
                            <select name="status" class="form-select">
                                <option value="PAID">LUNAS (PAID)</option>
                                <option value="UNPAID">BELUM LUNAS</option>
                            </select>
                        </div>

                        <div class="card bg-warning text-white shadow-sm mt-4">
                            <div class="card-body py-2 px-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="processCheck" name="process_provider" value="1" checked>
                                    <label class="form-check-label font-weight-bold" for="processCheck">
                                        Proses Transaksi ke Server?
                                    </label>
                                </div>
                                <small class="d-block mt-1 text-white-50" style="font-size: 0.75rem;">
                                    *Saldo Digiflazz akan terpotong jika opsi ini dicentang & status LUNAS.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 shadow">
                        <i class="fas fa-save mr-2"></i> Simpan Transaksi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // Toggle Mode Manual vs DB
    const modeSwitch = document.getElementById('modeManual');
    const sectionDB = document.getElementById('section-db');
    const sectionManual = document.getElementById('section-manual');

    modeSwitch.addEventListener('change', function() {
        if(this.checked) {
            sectionDB.style.display = 'none';
            sectionManual.style.display = 'block';
        } else {
            sectionDB.style.display = 'block';
            sectionManual.style.display = 'none';
        }
    });

    // Load Data Produk DB
    const products = @json(\App\Models\Product::all());
    document.getElementById('game_select').addEventListener('change', function() {
        const gameCode = this.value;
        const productSelect = document.getElementById('product_select');
        productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';
        
        products.filter(p => p.game_code === gameCode).forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.code;
            opt.textContent = `${p.name} - Rp ${new Intl.NumberFormat('id-ID').format(p.price)}`;
            productSelect.appendChild(opt);
        });
    });
</script>
@endsection