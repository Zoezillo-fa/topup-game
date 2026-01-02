<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            
            // 1. Kolom Price (Harga Modal/Jual)
            if (!Schema::hasColumn('transactions', 'price')) {
                $table->bigInteger('price')->default(0)->after('amount');
            }

            // 2. Kolom Target (No HP / ID Game) - INI YANG ERROR
            if (!Schema::hasColumn('transactions', 'target')) {
                $table->string('target')->nullable()->after('price'); 
            }

            // 3. Kolom Payment (Metode Pembayaran)
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method', 50)->nullable()->after('target'); 
            }
            if (!Schema::hasColumn('transactions', 'payment_provider')) {
                $table->string('payment_provider', 50)->nullable()->after('payment_method'); 
            }

            // 4. Kolom Service (Jenis Layanan)
            if (!Schema::hasColumn('transactions', 'service')) {
                $table->string('service', 50)->nullable()->after('status'); // DEPOSIT / GAME
            }
            if (!Schema::hasColumn('transactions', 'service_name')) {
                $table->string('service_name')->nullable()->after('service'); // Isi Saldo / Mobile Legends
            }

            // 5. Kolom SN & Note (Bukti Transaksi)
            if (!Schema::hasColumn('transactions', 'sn')) {
                $table->string('sn')->nullable()->after('status');
            }
            if (!Schema::hasColumn('transactions', 'note')) {
                $table->text('note')->nullable()->after('sn');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'target',
                'payment_method', 
                'payment_provider',
                'service', 
                'service_name',
                'sn',
                'note'
            ]);
        });
    }
};