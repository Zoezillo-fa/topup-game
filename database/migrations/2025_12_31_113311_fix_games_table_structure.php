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
            // 1. Tambahkan kolom yang hilang (sesuai error Anda)
            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug')->nullable()->after('code'); // Kolom Slug URL
            }
            if (!Schema::hasColumn('games', 'endpoint')) {
                $table->string('endpoint')->nullable()->after('slug'); // Kolom Cek ID
            }
            if (!Schema::hasColumn('games', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('endpoint'); // Status Aktif
            }

            // 2. Ubah kolom wajib menjadi Boleh Kosong (Nullable)
            // Ini PENTING agar Sync Otomatis tidak error saat gambar/publisher kosong
            $table->string('publisher')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
            $table->string('banner')->nullable()->change();
            
            // 3. (Opsional) Sesuaikan kolom lama jika ada
            if (Schema::hasColumn('games', 'target_endpoint')) {
                $table->string('target_endpoint')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['slug', 'endpoint', 'is_active']);
            
            // Kembalikan ke wajib isi (Not Null) - Hati-hati ini bisa error jika ada data null
            // $table->string('publisher')->nullable(false)->change();
        });
    }
};