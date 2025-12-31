<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Tambahkan library string

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Diperketat & Dilengkapi)
        $request->validate([
            'title' => 'required|string|max:255', // Judul untuk caption banner
            'code' => 'required|unique:promos,code|alpha_dash', 
            'type' => 'required|in:percent,flat',
            'value' => 'required|numeric|min:1',
            'max_usage' => 'nullable|numeric',
            'description' => 'nullable|string',
            // Validasi Gambar Aman (Wajib JPG/PNG/WEBP, Maks 2MB)
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        try {
            $data = [
                'title' => $request->title,
                'code' => strtoupper($request->code),
                'type' => $request->type,
                'value' => $request->value,
                'max_usage' => $request->max_usage ?? 0,
                'description' => $request->description,
                'is_active' => true,
            ];

            // 2. Upload Gambar Aman (Secure Rename)
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Rename acak 40 karakter
                $filename = 'promo_' . Str::random(40) . '.' . $file->getClientOriginalExtension();
                
                // Simpan ke folder public/images/banner
                $file->move(public_path('images/banner'), $filename);
                
                // Simpan path database
                $data['image'] = '/images/banner/' . $filename;
            }

            Promo::create($data);

            return back()->with('success', 'Kode Promo & Banner berhasil dibuat!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        
        // Hapus file gambar fisik agar server tidak penuh
        if ($promo->image && file_exists(public_path($promo->image))) {
            @unlink(public_path($promo->image));
        }

        $promo->delete();
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