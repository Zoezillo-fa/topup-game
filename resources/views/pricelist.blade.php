@extends('layouts.main')

@section('title', 'Daftar Harga')

@section('content')
<div class="container py-5">
    
    <div class="text-center mb-5">
        <h3 class="fw-bold text-white text-uppercase">Daftar Harga Resmi</h3>
        <p class="text-secondary">Dapatkan harga lebih murah dengan menjadi Member VIP.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card bg-dark border-secondary shadow-sm mb-4">
                <div class="card-body p-4">
                    <label class="text-white fw-bold mb-2">Pilih Game:</label>
                    <select id="selectGame" class="form-select bg-dark text-white border-secondary" onchange="showGameTable()">
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
                    
                    <div class="card bg-dark border-secondary shadow-sm overflow-hidden">
                        
                        <div class="card-header border-secondary py-3 d-flex align-items-center bg-gradient-dark">
                            <img src="{{ asset($game->thumbnail) }}" class="rounded me-3" style="width: 35px; height: 35px; object-fit: cover;">
                            <h5 class="mb-0 text-white fw-bold">{{ $game->name }}</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle text-center">
                                <thead>
                                    <tr class="text-secondary small text-uppercase" style="border-bottom: 1px solid #374151;">
                                        <th rowspan="2" class="py-3 ps-4 text-start" width="15%">KODE</th>
                                        <th rowspan="2" class="py-3 text-start" width="35%">LAYANAN</th>
                                        <th colspan="2" class="py-2 text-center border-start border-secondary bg-dark-lighter">HARGA</th>
                                        <th rowspan="2" class="py-3 pe-4 text-end" width="15%">STATUS</th>
                                    </tr>
                                    <tr class="text-secondary small text-uppercase">
                                        <th class="py-2 text-warning border-start border-secondary bg-dark-lighter">MEMBER</th>
                                        <th class="py-2 text-info bg-dark-lighter">VIP <i class="bi bi-crown-fill ms-1"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($game->products as $product)
                                    <tr>
                                        <td class="py-3 ps-4 text-start fw-medium text-white-50 font-monospace small">
                                            {{ $product->code }}
                                        </td>

                                        <td class="py-3 text-start text-white">
                                            {{ $product->name }}
                                        </td>

                                        <td class="py-3 fw-bold text-warning border-start border-secondary bg-dark-lighter">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>

                                        <td class="py-3 fw-bold text-info bg-dark-lighter">
                                            Rp {{ number_format($product->price_vip, 0, ',', '.') }}
                                        </td>

                                        <td class="py-3 pe-4 text-end">
                                            @if($product->is_active)
                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-2 text-end">
                        <small class="text-secondary fst-italic">*Harga dapat berubah sewaktu-waktu.</small>
                    </div>

                </div>
                @endif
            @endforeach

        </div>
    </div>
</div>

<script>
    function showGameTable() {
        document.querySelectorAll('.game-table').forEach(t => t.classList.add('d-none'));
        const selectedId = document.getElementById('selectGame').value;
        const target = document.getElementById(selectedId);
        if(target) target.classList.remove('d-none');
    }
</script>

<style>
    .bg-gradient-dark { background: linear-gradient(180deg, #212529, #1a1d20); }
    .bg-dark-lighter { background-color: #2c3036 !important; }
    .table-hover tbody tr:hover { background-color: #353a40; }
</style>
@endsection