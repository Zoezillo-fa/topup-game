<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Configuration;

class ServerController extends Controller
{
    /**
     * Menampilkan Halaman Konfigurasi Server
     */
    public function index()
    {
        // 1. Cek IP Public
        try {
            $publicIp = Http::timeout(3)->get('https://api.ipify.org')->body();
        } catch (\Exception $e) {
            $publicIp = 'Gagal mendeteksi IP (Pastikan terkoneksi internet)';
        }

        // 2. Kumpulkan Informasi Server
        $serverInfo = [
            'ip_address' => $publicIp,
            'local_ip'   => $_SERVER['SERVER_ADDR'] ?? request()->server('SERVER_ADDR') ?? '127.0.0.1',
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'database_connection' => config('database.default'),
            'server_time' => now()->format('d M Y H:i:s T'),
        ];

        // 3. Cek Status Maintenance
        $maintenanceMode = Configuration::getBy('is_maintenance') == 'true';

        return view('admin.config.server', compact('serverInfo', 'maintenanceMode'));
    }

    /**
     * Fitur: Bersihkan Cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            return back()->with('success', 'Cache sistem berhasil dibersihkan! Website kini lebih segar.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    /**
     * Fitur: Aktifkan/Matikan Mode Maintenance
     */
    public function toggleMaintenance(Request $request)
    {
        $status = $request->status ? 'true' : 'false';
        
        Configuration::set('is_maintenance', $status);
        
        $msg = $status == 'true' 
            ? 'Website masuk mode MAINTENANCE. Hanya Admin yang bisa akses.' 
            : 'Website kini ONLINE kembali. Member bisa bertransaksi.';

        return back()->with('success', $msg);
    }

    // ==========================================
    // [UPDATE] FITUR KONFIGURASI WEBSITE & HALAMAN
    // ==========================================

    /**
     * Menampilkan Form Konfigurasi Website (Tab Umum & Halaman)
     */
    public function webView()
    {
        return view('admin.config.web');
    }

    /**
     * Memproses Penyimpanan Konfigurasi Website
     */
    public function updateWeb(Request $request)
    {
        // 1. Simpan Config Umum
        if($request->has('app_name')) Configuration::set('app_name', $request->app_name);
        if($request->has('footer_description')) Configuration::set('footer_description', $request->footer_description);
        if($request->has('whatsapp_number')) Configuration::set('whatsapp_number', $request->whatsapp_number);

        // 2. Upload Logo & Banner Utama
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('images/settings', 'public');
            Configuration::set('app_logo', '/storage/' . $path);
        }
        if ($request->hasFile('app_banner')) {
            $path = $request->file('app_banner')->store('images/settings', 'public');
            Configuration::set('app_banner', '/storage/' . $path);
        }

        // 3. Upload Logo Pembayaran Footer (Slot 1-4)
        for ($i = 1; $i <= 4; $i++) {
            $key = 'payment_logo_' . $i;
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('images/settings', 'public');
                Configuration::set($key, '/storage/' . $path);
            }
        }

        // 4. Simpan Konten Halaman
        if($request->has('page_about')) Configuration::set('page_about', $request->page_about);
        if($request->has('page_privacy')) Configuration::set('page_privacy', $request->page_privacy);
        if($request->has('page_terms')) Configuration::set('page_terms', $request->page_terms);
        if($request->has('page_faq')) Configuration::set('page_faq', $request->page_faq);

        return back()->with('success', 'Konfigurasi website berhasil diperbarui!');
    }
}