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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();         // Kode Voucher (Misal: MERDEKA45)
            $table->enum('type', ['percent', 'flat']); // Tipe: Persen (%) atau Potongan Harga (Rp)
            $table->decimal('value', 15, 2);          // Nilainya (Misal: 10 untuk 10%, atau 5000 untuk Rp 5000)
            $table->integer('max_usage')->default(0); // Batas pemakaian (0 = Unlimited)
            $table->boolean('is_active')->default(true); // Status Aktif/Mati
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
