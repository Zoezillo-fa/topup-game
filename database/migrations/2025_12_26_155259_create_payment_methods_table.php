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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Cth: MYBVA, QRIS, GOPAY
            $table->string('name');           // Cth: Maybank Virtual Account
            $table->string('type');           // Cth: e_wallet, virtual_account, retail
            $table->string('image')->nullable(); // Logo Pembayaran
            $table->decimal('admin_fee_flat', 10, 2)->default(0); // Biaya admin Rp
            $table->decimal('admin_fee_percent', 5, 2)->default(0); // Biaya admin %
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
