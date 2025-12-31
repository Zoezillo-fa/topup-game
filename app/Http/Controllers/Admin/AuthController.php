<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // [BARU] Import Model User
use Illuminate\Support\Facades\Hash; // [BARU] Import Hash Password

class AuthController extends Controller
{
    // --- LOGIN ---
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek apakah dia Admin?
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Anda bukan Admin!']);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // --- [BARU] REGISTER ---
    public function register()
    {
        return view('admin.auth.register');
    }

    public function registerProcess(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Email harus unik
            'password' => 'required|min:6|confirmed', // Harus ada input 'password_confirmation'
        ]);

        // 2. Buat User Baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin', // [PENTING] Set role langsung jadi ADMIN
        ]);

        // 3. Langsung Login & Redirect
        Auth::login($user);
        
        return redirect()->route('admin.dashboard')->with('success', 'Akun admin berhasil dibuat!');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}