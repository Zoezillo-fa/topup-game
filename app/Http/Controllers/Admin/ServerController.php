<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http; // Wajib import ini untuk cek IP
use App\Models\Configuration;

class ServerController extends Controller
{
    /**
     * Menampilkan Halaman Konfigurasi Server
     */
    public function index()
    {
        // 1. Cek IP Public (Yang dilihat oleh Digiflazz/Tripay)
        // Kita gunakan layanan eksternal ipify.org dengan timeout 3 detik
        try {
            $publicIp = Http::timeout(3)->get('https://api.ipify.org')->body();
        } catch (\Exception $e) {
            // Jika internet mati atau ipify down, tampilkan pesan error
            $publicIp = 'Gagal mendeteksi IP (Pastikan terkoneksi internet)';
        }

        // 2. Kumpulkan Informasi Server
        $serverInfo = [
            'ip_address' => $publicIp, // IP Public (Penting)
            'local_ip'   => $_SERVER['SERVER_ADDR'] ?? request()->server('SERVER_ADDR') ?? '127.0.0.1', // IP Lokal
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'database_connection' => config('database.default'),
            'server_time' => now()->format('d M Y H:i:s T'),
        ];

        // 3. Cek Status Maintenance dari Database
        // Mengambil value 'true' atau 'false' string
        $maintenanceMode = Configuration::getBy('is_maintenance') == 'true';

        return view('admin.config.server', compact('serverInfo', 'maintenanceMode'));
    }

    /**
     * Fitur: Bersihkan Cache (Artisan Optimize Clear)
     */
    public function clearCache()
    {
        try {
            // Menjalankan perintah terminal: php artisan optimize:clear
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
        // Jika status dikirim 1, berarti mau Maintenance (true)
        // Jika status dikirim 0, berarti mau Online (false)
        $status = $request->status ? 'true' : 'false';
        
        // Simpan ke database configuration
        Configuration::set('is_maintenance', $status);
        
        $msg = $status == 'true' 
            ? 'Website masuk mode MAINTENANCE. Hanya Admin yang bisa akses.' 
            : 'Website kini ONLINE kembali. Member bisa bertransaksi.';

        return back()->with('success', $msg);
    }
}