@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah User
    </a>
</div>

{{-- Alert Error jika saldo kurang saat dikurangi --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Saldo</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold">{{ $user->name }}</div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="text-success fw-bold">
                            Rp {{ number_format($user->balance ?? 0, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">ADMIN</span>
                            @else
                                <span class="badge bg-info text-dark">MEMBER</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-end pe-4">
                            {{-- TOMBOL ATUR SALDO (Baru) --}}
                            <button type="button" 
                                    class="btn btn-sm btn-outline-success me-1" 
                                    onclick="openBalanceModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->balance }}')">
                                <i class="bi bi-wallet2"></i>
                            </button>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
</div>

{{-- MODAL ATUR SALDO --}}
<div class="modal fade" id="balanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Atur Saldo Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="balanceForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">User: <strong id="modalUserName"></strong></p>
                    <p class="mb-3 text-muted small">Saldo Saat Ini: Rp <span id="modalCurrentBalance"></span></p>
                    
                    <div class="mb-3">
                        <label class="form-label">Tindakan</label>
                        <select name="type" class="form-select" required>
                            <option value="add">Tambah Saldo (+)</option>
                            <option value="sub">Kurangi Saldo (-)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal (Rp)</label>
                        <input type="number" name="amount" class="form-control" placeholder="Contoh: 50000" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SEDERHANA UNTUK MODAL --}}
<script>
    function openBalanceModal(id, name, balance) {
        // Set Action Form URL secara dinamis
        let form = document.getElementById('balanceForm');
        form.action = '/admin/users/' + id + '/balance';

        // Set Nama & Saldo di tampilan modal
        document.getElementById('modalUserName').innerText = name;
        document.getElementById('modalCurrentBalance').innerText = new Intl.NumberFormat('id-ID').format(balance);

        // Buka Modal (Bootstrap 5)
        let myModal = new bootstrap.Modal(document.getElementById('balanceModal'));
        myModal.show();
    }
</script>
@endsection