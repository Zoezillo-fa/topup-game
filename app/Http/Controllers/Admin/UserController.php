<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. TAMPILKAN DAFTAR USER
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // 2. FORM TAMBAH USER
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. SIMPAN USER BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,member',
            // [BARU] Validasi input saldo
            'balance' => 'nullable|numeric|min:0', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // [BARU] Simpan saldo (default 0 jika tidak diisi)
            'balance' => $request->balance ?? 0, 
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. FORM EDIT USER
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 5. UPDATE DATA USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,member',
            // Password nullable (kalau kosong, berarti tidak diganti)
            'password' => 'nullable|min:6',
            // [BARU] Validasi input saldo saat update
            'balance' => 'nullable|numeric|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            // [BARU] Update saldo (gunakan nilai lama atau 0 jika kosong)
            'balance' => $request->balance ?? 0,
        ];

        // Cek apakah password diisi?
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. HAPUS USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    // 7. [FITUR BARU] UPDATE SALDO MANUAL (Deposit/Withdraw)
    public function updateBalance(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'type'   => 'required|in:add,sub', // add = Tambah, sub = Kurangi
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $request->amount;

        if ($request->type == 'add') {
            // Menambah Saldo
            $user->increment('balance', $amount);
            $message = 'Saldo berhasil ditambahkan sebesar Rp ' . number_format($amount);
        } else {
            // Mengurangi Saldo
            if ($user->balance < $amount) {
                return back()->with('error', 'Saldo user tidak mencukupi untuk pengurangan ini!');
            }
            $user->decrement('balance', $amount);
            $message = 'Saldo berhasil dikurangi sebesar Rp ' . number_format($amount);
        }

        return back()->with('success', $message);
    }
}