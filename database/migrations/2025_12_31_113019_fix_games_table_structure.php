<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // 1. Tambahkan kolom yang hilang (sesuai error & controller)
            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug')->nullable()->after('code'); // Slug URL
            }
            if (!Schema::hasColumn('games', 'endpoint')) {
                $table->string('endpoint')->nullable()->after('slug'); // Endpoint Cek ID
            }
            if (!Schema::hasColumn('games', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('endpoint'); // Status Aktif
            }

            // 2. Ubah kolom wajib menjadi Boleh Kosong (Nullable)
            // Agar saat sync otomatis tidak error karena gambar/publisher belum ada
            $table->string('publisher')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
            $table->string('banner')->nullable()->change();
            
            // Opsional: Jadikan target_endpoint nullable juga jika Anda beralih ke 'endpoint'
            $table->string('target_endpoint')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['slug', 'endpoint', 'is_active']);
            // Mengembalikan ke not null sulit dilakukan tanpa data valid, jadi biarkan saja.
        });
    }
};