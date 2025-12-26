<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $payments = [
            // E-Wallets & QRIS
            ['code' => 'QRIS', 'name' => 'QRIS All Payment', 'type' => 'e_wallet', 'image' => 'https://tripay.co.id/images/payment-channel/qris.png', 'admin_fee_flat' => 750, 'admin_fee_percent' => 0.7],
            ['code' => 'OVO', 'name' => 'OVO', 'type' => 'e_wallet', 'image' => 'https://tripay.co.id/images/payment-channel/ovo.png', 'admin_fee_flat' => 0, 'admin_fee_percent' => 3],
            ['code' => 'DANA', 'name' => 'DANA', 'type' => 'e_wallet', 'image' => 'https://tripay.co.id/images/payment-channel/dana.png', 'admin_fee_flat' => 0, 'admin_fee_percent' => 3],
            ['code' => 'SHOPEEPAY', 'name' => 'ShopeePay', 'type' => 'e_wallet', 'image' => 'https://tripay.co.id/images/payment-channel/shopeepay.png', 'admin_fee_flat' => 0, 'admin_fee_percent' => 3],
            
            // Virtual Accounts
            ['code' => 'MYBVA', 'name' => 'Maybank VA', 'type' => 'virtual_account', 'image' => 'https://tripay.co.id/images/payment-channel/maybankva.png', 'admin_fee_flat' => 4250, 'admin_fee_percent' => 0],
            ['code' => 'PERMATAVA', 'name' => 'Permata VA', 'type' => 'virtual_account', 'image' => 'https://tripay.co.id/images/payment-channel/permatava.png', 'admin_fee_flat' => 4250, 'admin_fee_percent' => 0],
            ['code' => 'BRIVA', 'name' => 'BRI VA', 'type' => 'virtual_account', 'image' => 'https://tripay.co.id/images/payment-channel/briva.png', 'admin_fee_flat' => 4250, 'admin_fee_percent' => 0],
            ['code' => 'BNIVA', 'name' => 'BNI VA', 'type' => 'virtual_account', 'image' => 'https://tripay.co.id/images/payment-channel/bniva.png', 'admin_fee_flat' => 4250, 'admin_fee_percent' => 0],
            ['code' => 'MANDIRIVA', 'name' => 'Mandiri VA', 'type' => 'virtual_account', 'image' => 'https://tripay.co.id/images/payment-channel/mandiriva.png', 'admin_fee_flat' => 4250, 'admin_fee_percent' => 0],
            
            // Retail
            ['code' => 'ALFAMART', 'name' => 'Alfamart', 'type' => 'retail', 'image' => 'https://tripay.co.id/images/payment-channel/alfamart.png', 'admin_fee_flat' => 6000, 'admin_fee_percent' => 0],
        ];

        DB::table('payment_methods')->insert($payments);
    }
}