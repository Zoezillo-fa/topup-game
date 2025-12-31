<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & Member
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@topup.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Member Test',
            'email' => 'member@gmail.com',
            'password' => 'password123',
            'role' => 'member',
        ]);

        // 2. Panggil Seeder Game & Payment
        $this->call([
            GameSeeder::class,
            PaymentMethodSeeder::class,
        ]);
        
        // Catatan: Product biasanya di-sync dari Digiflazz, jadi tidak perlu di-seed manual.
    }
}