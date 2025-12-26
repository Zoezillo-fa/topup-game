<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Configuration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncProducts extends Command
{
    /**
     * Nama command yang akan dipanggil di Cron Job / Terminal
     */
    protected $signature = 'product:sync-digiflazz';

    protected $description = 'Sinkronisasi harga modal produk dari Digiflazz secara otomatis';

    public function handle()
    {
        $this->info('Memulai Auto Sync Digiflazz...');

        // 1. Ambil Kredensial
        $username = Configuration::getBy('digiflazz_username');
        $key = Configuration::getBy('digiflazz_key');

        if (!$username || !$key) {
            $this->error('API Key Digiflazz belum disetting di database.');
            return;
        }

        $sign = md5($username . $key . "pricelist");

        // 2. Request ke Digiflazz
        try {
            // Timeout 60 detik agar tidak putus di tengah jalan
            $response = Http::timeout(60)->post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => $username,
                'sign' => $sign
            ]);
            $result = $response->json();
        } catch (\Exception $e) {
            Log::error("AutoSync Gagal: " . $e->getMessage());
            $this->error("Gagal koneksi: " . $e->getMessage());
            return;
        }

        // 3. Validasi Data
        if (!isset($result['data']) || !is_array($result['data'])) {
            Log::error("AutoSync Gagal: Data API kosong/format salah.");
            return;
        }

        // 4. Proses Update Harga
        $count = 0;
        foreach ($result['data'] as $item) {
            $sku = $item['buyer_sku_code'];
            $modalBaru = $item['price'];
            
            // Status harus AKTIF di Buyer (Kita) dan Seller (Digiflazz)
            $isActive = $item['buyer_product_status'] && $item['seller_product_status'];

            // Update produk di database kita berdasarkan SKU
            // Kita HANYA update 'cost_price' dan 'is_active'. 
            // Harga jual (price) TIDAK diubah agar margin Anda tetap terjaga sesuai settingan.
            $affected = Product::where('sku_provider', $sku)
                ->orWhere('code', $sku)
                ->update([
                    'cost_price' => $modalBaru,
                    'is_active' => $isActive ? 1 : 0
                ]);

            if ($affected) {
                $count++;
            }
        }

        $this->info("Sukses! $count produk telah diperbarui.");
        Log::info("AutoSync Berjalan: $count produk diperbarui.");
    }
}