<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        $payments = [
            // ==========================================
            // 1. TRIPAY CHANNELS
            // ==========================================
            
            // --- E-Wallets & QRIS (Fee Persen) ---
            [
                'code' => 'QRIS', 
                'name' => 'QRIS (All Payment)', 
                'type' => 'e_wallet', 
                'image' => 'https://tripay.co.id/images/payment-channel/qris.png', 
                'admin_fee_flat' => 750, 
                'admin_fee_percent' => 0.70,
                'provider' => 'tripay', // <--- Set Provider
                'is_active' => true,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'OVO', 
                'name' => 'OVO', 
                'type' => 'e_wallet', 
                'image' => 'https://tripay.co.id/images/payment-channel/ovo.png', 
                'admin_fee_flat' => 0, 
                'admin_fee_percent' => 3.00,
                'provider' => 'tripay',
                'is_active' => true,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'DANA', 
                'name' => 'DANA', 
                'type' => 'e_wallet', 
                'image' => 'https://tripay.co.id/images/payment-channel/dana.png', 
                'admin_fee_flat' => 0, 
                'admin_fee_percent' => 3.00,
                'provider' => 'tripay',
                'is_active' => true,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'SHOPEEPAY', 
                'name' => 'ShopeePay', 
                'type' => 'e_wallet', 
                'image' => 'https://tripay.co.id/images/payment-channel/shopeepay.png', 
                'admin_fee_flat' => 0, 
                'admin_fee_percent' => 3.00,
                'provider' => 'tripay',
                'is_active' => true,
                'created_at' => $now, 'updated_at' => $now
            ],

            // --- Virtual Accounts (Fee Flat Rp 4.250) ---
            [
                'code' => 'MYBVA', 'name' => 'Maybank VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/maybankva.png', 
                'admin_fee_flat' => 4250, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'PERMATAVA', 'name' => 'Permata VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/permatava.png', 
                'admin_fee_flat' => 4250, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'BRIVA', 'name' => 'BRI VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/briva.png', 
                'admin_fee_flat' => 4250, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'BNIVA', 'name' => 'BNI VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/bniva.png', 
                'admin_fee_flat' => 4250, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'MANDIRIVA', 'name' => 'Mandiri VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/mandiriva.png', 
                'admin_fee_flat' => 4250, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'BCAVA', 'name' => 'BCA VA', 'type' => 'virtual_account', 
                'image' => 'https://tripay.co.id/images/payment-channel/bcava.png', 
                'admin_fee_flat' => 5500, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            
            // --- Retail / Minimarket ---
            [
                'code' => 'ALFAMART', 'name' => 'Alfamart', 'type' => 'retail', 
                'image' => 'https://tripay.co.id/images/payment-channel/alfamart.png', 
                'admin_fee_flat' => 6000, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'INDOMARET', 'name' => 'Indomaret', 'type' => 'retail', 
                'image' => 'https://tripay.co.id/images/payment-channel/indomaret.png', 
                'admin_fee_flat' => 3500, 'admin_fee_percent' => 0,
                'provider' => 'tripay',
                'is_active' => true, 'created_at' => $now, 'updated_at' => $now
            ],

            // ==========================================
            // 2. MIDTRANS CHANNELS (Baru)
            // ==========================================
            [
                'code' => 'gopay', 
                'name' => 'GoPay (Midtrans)', 
                'type' => 'e_wallet', 
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/gopay.png', 
                'admin_fee_flat' => 0, 
                'admin_fee_percent' => 2.00, // Fee GoPay biasanya 2%
                'provider' => 'midtrans', // <--- Provider Midtrans
                'is_active' => true, 
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'code' => 'bca_va', 
                'name' => 'BCA Virtual Account (Midtrans)',
                'type' => 'virtual_account',
                'image' => 'https://docs.midtrans.com/asset/image/payment-list/bca.png',
                'admin_fee_flat' => 4000, 
                'admin_fee_percent' => 0,
                'provider' => 'midtrans', // <--- Provider Midtrans
                'is_active' => true, 
                'created_at' => $now, 'updated_at' => $now
            ],
        ];

        DB::table('payment_methods')->insert($payments);
    }
}