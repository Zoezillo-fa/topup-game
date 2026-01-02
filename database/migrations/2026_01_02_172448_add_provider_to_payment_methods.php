<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            // Default 'tripay' agar data lama tetap jalan
            $table->string('provider')->default('tripay')->after('code'); 
            // Tambahkan kolom untuk kode spesifik provider jika perlu (opsional)
            // $table->string('provider_code')->nullable()->after('provider');
        });
    }

    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('provider');
        });
    }
};
