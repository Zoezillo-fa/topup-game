@extends('layouts.admin')

@section('title', 'Sinkronisasi Produk')

@section('content')
<div class="container-fluid py-3">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Ambil Produk Supplier</h4>
            <p class="text-secondary small mb-0">Sinkronisasi otomatis dari Digiflazz.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                <i class="bi bi-hdd-network me-2"></i>Status: Terhubung
            </span>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <ul class="nav nav-pills mb-4 gap-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold border px-4 py-2" id="pills-manual-tab" data-bs-toggle="pill" data-bs-target="#pills-manual" type="button" role="tab">
                <i class="bi bi-cursor-fill me-2"></i> Mode Manual (Per Game)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold border px-4 py-2 text-warning bg-dark" id="pills-auto-tab" data-bs-toggle="pill" data-bs-target="#pills-auto" type="button" role="tab">
                <i class="bi bi-robot me-2"></i> Mode Otomatis (Semua Game)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <div class="tab-pane fade show active" id="pills-manual" role="tabpanel">
            <form action="{{ route('admin.products.sync.process') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="fw-bold m-0 text-primary">Konfigurasi Manual</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="fw-bold small mb-2">Target Game (Lokal)</label>
                                        <select name="game_code" class="form-select bg-light" required>
                                            <option value="">-- Pilih Game --</option>
                                            @foreach($games as $game)
                                                <option value="{{ $game->code }}">{{ $game->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="fw-bold small mb-2">Brand Digiflazz</label>
                                        <div class="input-group">
                                            <input type="text" id="inputBrand" name="provider_brand" class="form-control bg-light" placeholder="Cth: MOBILE LEGENDS" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="loadBrands()">
                                                <i class="bi bi-search me-1"></i> Lihat List
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @include('admin.products.partials.margin_inputs') 
                                
                                <button type="submit" class="btn btn-primary w-100 py-3 mt-4 fw-bold shadow-sm">
                                    <i class="bi bi-cloud-arrow-down-fill me-2"></i> TARIK PRODUK (MANUAL)
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 p-4">
                            <h6 class="fw-bold text-warning mb-3">Panduan Manual</h6>
                            <p class="small text-white-50">Gunakan mode ini jika nama game di database Anda berbeda dengan Digiflazz (Misal: DB="MLBB", Digi="Mobile Legends").</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="pills-auto" role="tabpanel">
            <form action="{{ route('admin.products.sync.all') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-warning border-top border-5">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="fw-bold m-0 text-warning"><i class="bi bi-stars me-2"></i>Sync Semua Game Sekaligus</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-warning border-0 d-flex align-items-center mb-4">
                                    <i class="bi bi-exclamation-circle fs-1 me-3"></i>
                                    <div>
                                        <strong>Perhatian:</strong> Sistem akan mencari otomatis produk berdasarkan <b>Nama Game</b> di database Anda.
                                        <br><span class="small">Pastikan nama game di Database COCOK dengan Brand di Digiflazz.</span>
                                    </div>
                                </div>

                                @include('admin.products.partials.margin_inputs')

                                <button type="submit" class="btn btn-warning w-100 py-3 mt-4 fw-bold shadow-sm text-dark">
                                    <i class="bi bi-lightning-charge-fill me-2"></i> MULAI SYNC SEMUA GAME
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 p-4">
                            <h6 class="fw-bold text-warning mb-3">Cara Kerja Otomatis</h6>
                            <ul class="small text-white-50 ps-3 mb-0">
                                <li class="mb-2">Sistem menarik <b>ribuan data</b> dari Digiflazz.</li>
                                <li class="mb-2">Sistem mengecek setiap game yang ada di database Anda.</li>
                                <li class="mb-2">Jika Nama Game cocok dengan Brand Digiflazz, produk akan ditambahkan/diupdate.</li>
                                <li>Proses ini memakan waktu <b>1-3 menit</b>. Jangan tutup halaman.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-tags-fill me-2"></i>Daftar Brand Digiflazz</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <input type="text" id="searchBrand" class="form-control mb-3 sticky-top shadow-sm" placeholder="🔍 Cari nama game..." onkeyup="filterBrands()">
                
                <div id="loadingBrands" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="small text-muted mt-2">Sedang mengambil data dari Digiflazz...</p>
                </div>

                <div id="brandList" class="list-group d-none">
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadBrands() {
        const modal = new bootstrap.Modal(document.getElementById('brandModal'));
        modal.show();

        const listContainer = document.getElementById('brandList');
        const loading = document.getElementById('loadingBrands');

        listContainer.innerHTML = '';
        listContainer.classList.add('d-none');
        loading.classList.remove('d-none');

        // Pastikan route 'admin.products.brands' sudah dibuat di web.php
        fetch("{{ route('admin.products.brands') }}")
            .then(response => response.json())
            .then(res => {
                loading.classList.add('d-none');
                listContainer.classList.remove('d-none');

                if(res.status === 'success') {
                    res.data.forEach(brand => {
                        const btn = document.createElement('button');
                        btn.className = 'list-group-item list-group-item-action py-2 brand-item';
                        btn.innerHTML = `<i class="bi bi-caret-right-fill text-secondary me-2 small"></i> ${brand}`;
                        btn.onclick = function() {
                            document.getElementById('inputBrand').value = brand;
                            modal.hide();
                        };
                        listContainer.appendChild(btn);
                    });
                } else {
                    listContainer.innerHTML = `<div class="alert alert-danger">${res.message}</div>`;
                }
            })
            .catch(err => {
                loading.classList.add('d-none');
                listContainer.innerHTML = `<div class="alert alert-danger">Gagal koneksi: ${err}</div>`;
            });
    }

    function filterBrands() {
        const input = document.getElementById('searchBrand').value.toUpperCase();
        const items = document.getElementsByClassName('brand-item');
        for (let i = 0; i < items.length; i++) {
            const txtValue = items[i].textContent || items[i].innerText;
            if (txtValue.toUpperCase().indexOf(input) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }
</script>
@endsection