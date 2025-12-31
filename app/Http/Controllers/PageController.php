<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration; // Import Model Configuration

class PageController extends Controller
{
    /**
     * Helper: Mengambil konten dari database.
     * Jika kosong, tampilkan pesan default.
     */
    private function getContent($key, $title) {
        // Ambil data dari tabel configurations
        $content = Configuration::getBy($key);
        
        // Jika belum disetting admin, tampilkan pesan placeholder
        if(!$content) {
            $content = "<div class='text-center text-muted py-5'>
                            <i class='bi bi-info-circle fs-1 mb-3 d-block'></i>
                            Belum ada informasi untuk halaman <b>$title</b>.<br>
                            Silakan update konten ini di <b>Admin Panel > Pengaturan > Website Config</b>.
                        </div>";
        }
        
        // Ubah baris baru (\n) menjadi <br> agar rapi di HTML
        return nl2br($content);
    }

    // --- HALAMAN DINAMIS (Data dari Database) ---

    public function about() { 
        $title = 'Tentang Kami';
        $content = $this->getContent('page_about', $title);
        // Menggunakan view generic yang sudah kita buat sebelumnya
        return view('pages.generic', compact('title', 'content'));
    }

    public function privacy() { 
        $title = 'Kebijakan Privasi';
        $content = $this->getContent('page_privacy', $title);
        return view('pages.generic', compact('title', 'content'));
    }

    public function terms() { 
        $title = 'Syarat & Ketentuan';
        $content = $this->getContent('page_terms', $title);
        return view('pages.generic', compact('title', 'content'));
    }

    public function faq() { 
        $title = 'Pertanyaan Umum (FAQ)';
        $content = $this->getContent('page_faq', $title);
        return view('pages.generic', compact('title', 'content'));
    }
    
    // --- HALAMAN FITUR LAINNYA ---
    
    public function leaderboard() { return view('pages.leaderboard'); }
    public function calculator() { return view('pages.calculator'); }
    public function regionCheck() { return view('pages.region'); }
    
    // Redirect ke WA untuk Gabung Reseller
    public function reseller() {
        $phone = Configuration::getBy('whatsapp_number') ?? '628123456789';
        return redirect("https://wa.me/{$phone}?text=Halo%20Admin,%20saya%20tertarik%20gabung%20reseller.");
    }
}