<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GameSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan cek foreign key agar bisa truncate (kosongkan) tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('games')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        $games = [
            [
                'name' => 'Mobile Legends',
                'code' => 'mobile-legends',
                'publisher' => 'Moonton',
                'target_endpoint' => 'ml', // Kode untuk API Cek ID
                'thumbnail' => '/images/logo/mlbb.png',
                'banner' => '/images/banner/mlbb.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Free Fire',
                'code' => 'free-fire',
                'publisher' => 'Garena',
                'target_endpoint' => 'ff',
                'thumbnail' => '/images/logo/ff.png',
                'banner' => '/images/banner/ff.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Game lain bisa ditambahkan nanti (pastikan file gambarnya ada dulu)
            // [
            //     'name' => 'PUBG Mobile',
            //     'code' => 'pubg-mobile',
            //     'publisher' => 'Tencent',
            //     'target_endpoint' => 'pubgm',
            //     'thumbnail' => '/images/logo/pubgm.png',
            //     'banner' => '/images/banner/pubgm.jpg',
            //     'created_at' => $now,
            //     'updated_at' => $now,
            // ],
        ];

        DB::table('games')->insert($games);
    }
}