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
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku_provider')->nullable()->after('code'); // Kode di Digiflazz (Buyer SKU)
            $table->decimal('cost_price', 15, 2)->default(0)->after('price'); // Harga Modal
            $table->boolean('is_active')->default(true)->after('cost_price'); // Status Aktif/Mati
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku_provider', 'cost_price', 'is_active']);
        });
    }
};
