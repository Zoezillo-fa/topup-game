<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            // Hapus 'uppercase' dari sini karena bisa menyebabkan error di beberapa versi Laravel
            'code' => 'required|unique:promos,code|alpha_dash', 
            'type' => 'required|in:percent,flat',
            'value' => 'required|numeric|min:1',
            'max_usage' => 'nullable|numeric',
        ]);

        // 2. Simpan ke Database
        try {
            Promo::create([
                'code' => strtoupper($request->code), // KITA UBAH KE HURUF BESAR DI SINI
                'type' => $request->type,
                'value' => $request->value,
                'max_usage' => $request->max_usage ?? 0,
                'is_active' => true,
            ]);

            return back()->with('success', 'Kode Promo berhasil dibuat!');
            
        } catch (\Exception $e) {
            // Jika error database, tampilkan pesannya
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Promo::findOrFail($id)->delete();
        return back()->with('success', 'Promo berhasil dihapus.');
    }
    
    // Fitur Aktif/Nonaktifkan Promo
    public function toggle($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->update(['is_active' => !$promo->is_active]);
        return back()->with('success', 'Status promo diperbarui.');
    }
}