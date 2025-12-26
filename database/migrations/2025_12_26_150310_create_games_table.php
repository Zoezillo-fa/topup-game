<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Contoh: Mobile Legends
            $table->string('code')->unique();   // Contoh: mobile-legends (untuk URL)
            $table->string('publisher');        // Contoh: Moonton
            $table->string('thumbnail');        // URL Gambar Logo
            $table->string('banner');           // URL Gambar Banner Besar
            $table->string('target_endpoint');  // Kode API Cek ID (ml, ff, pubgm)
            $table->timestamps();
        });

        // Kita update juga tabel products agar punya relasi ke game
        Schema::table('products', function (Blueprint $table) {
            // Menambah kolom game_code setelah id
            $table->string('game_code')->after('id')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
