<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // 1. Tambahkan kolom yang hilang
            if (!Schema::hasColumn('transactions', 'target')) {
                $table->string('target')->nullable()->after('price'); // Untuk No HP User
            }
            if (!Schema::hasColumn('transactions', 'sn')) {
                $table->string('sn')->nullable()->after('status');    // Untuk Serial Number / Bukti
            }
            if (!Schema::hasColumn('transactions', 'note')) {
                $table->text('note')->nullable()->after('sn');        // Untuk Catatan
            }

            // 2. Ubah kolom wajib menjadi BOLEH KOSONG (Nullable)
            // Karena transaksi Deposit tidak punya Game ID & Produk Code
            $table->string('user_id_game')->nullable()->change();
            $table->string('product_code')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['target', 'sn', 'note']);
            // Kembalikan ke not null jika rollback (opsional, berisiko error data)
            // $table->string('user_id_game')->nullable(false)->change();
        });
    }
};