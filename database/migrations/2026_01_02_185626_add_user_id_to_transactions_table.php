<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Tambahkan kolom user_id setelah kolom id
            // Kita set nullable() agar transaksi Tamu (Guest) tetap bisa berjalan
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            
            // (Opsional) Tambahkan Foreign Key agar terhubung ke tabel users
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};