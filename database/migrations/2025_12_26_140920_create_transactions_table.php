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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('user_id_game');
            $table->string('product_code');
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('UNPAID');
            $table->string('tripay_reference')->nullable();
            $table->string('processing_status')->default('PENDING'); // <--- WAJIB ADA
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
