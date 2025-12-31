@extends('layouts.main')

@section('title', 'Daftar Harga')

@section('content')
<div class="container py-5">
    
    <div class="text-center mb-5">
        <h3 class="fw-bold text-white text-uppercase">Daftar Harga</h3>
        <p class="text-secondary">Cek harga produk termurah dan status server secara realtime.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card bg-dark border-secondary shadow-sm mb-4">
                <div class="card-body p-4">
                    <label class="text-white fw-bold mb-2">Pilih Game / Kategori</label>
                    <select id="selectGame" class="form-select bg-dark text-white border-secondary py-2" onchange="showGameTable()">
                        @foreach($games as $index => $game)
                            @if($game->products->count() > 0)
                                <option value="game-{{ $game->id }}" {{ $index == 0 ? 'selected' : '' }}>
                                    {{ $game->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            @foreach($games as $index => $game)
                @if($game->products->count() > 0)
                <div id="game-{{ $game->id }}" class="game-table {{ $index == 0 ? '' : 'd-none' }}">
                    
                    <div class="card bg-dark border-secondary shadow-sm">
                        
                        <div class="card-header border-secondary py-3 d-flex align-items-center bg-gradient-dark">
                            <img src="{{ asset($game->thumbnail) }}" class="rounded me-3" style="width: 35px; height: 35px; object-fit: cover;">
                            <h5 class="mb-0 text-white fw-bold">{{ $game->name }}</h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover mb-0 align-middle">
                                    <thead>
                                        <tr class="text-secondary small text-uppercase">
                                            <th class="ps-4 py-3" width="15%">KODE</th> <th class="py-3" width="40%">ITEM / LAYANAN</th>
                                            <th class="py-3 text-end" width="25%">HARGA</th>
                                            <th class="text-center py-3 pe-4" width="20%">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($game->products as $product)
                                        <tr>
                                            <td class="ps-4 py-3 fw-medium text-warning font-monospace small">
                                                {{ $product->code }}
                                            </td>

                                            <td class="py-3 text-white">
                                                {{ $product->name }}
                                            </td>

                                            <td class="py-3 text-end fw-bold text-white">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </td>

                                            <td class="text-center py-3 pe-4">
                                                @if($product->is_active)
                                                    <span class="badge bg-success bg-opacity-25 text-success rounded-pill px-3">
                                                        <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-25 text-danger rounded-pill px-3">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Gangguan
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                @endif
            @endforeach

        </div>
    </div>
</div>

<script>
    function showGameTable() {
        // 1. Sembunyikan semua tabel dulu
        const allTables = document.querySelectorAll('.game-table');
        allTables.forEach(table => {
            table.classList.add('d-none');
        });

        // 2. Ambil ID game yang dipilih dari dropdown
        const selectedId = document.getElementById('selectGame').value;

        // 3. Munculkan tabel yang sesuai
        const targetTable = document.getElementById(selectedId);
        if (targetTable) {
            targetTable.classList.remove('d-none');
        }
    }
</script>

<style>
    .bg-gradient-dark {
        background: linear-gradient(180deg, #212529, #1a1d20);
    }
    .form-select:focus {
        border-color: #facc15; /* Warna kuning saat diklik */
        box-shadow: 0 0 0 0.25rem rgba(250, 204, 21, 0.25);
    }
</style>
@endsection