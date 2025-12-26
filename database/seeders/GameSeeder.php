<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('games')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $games = [
            [
                'name' => 'Mobile Legends',
                'code' => 'mobile-legends',
                'publisher' => 'Moonton',
                'target_endpoint' => 'ml',
                // Perhatikan path-nya sekarang mengarah ke folder public/images
                'thumbnail' => '/images/logo/mlbb.png',
                'banner' => '/images/banner/mlbb.jpg',
            ],
            [
                'name' => 'Free Fire',
                'code' => 'free-fire',
                'publisher' => 'Garena',
                'target_endpoint' => 'ff',
                'thumbnail' => '/images/logo/ff.png',
                'banner' => '/images/banner/ff.jpg',
            ],
            [
                'name' => 'PUBG Mobile',
                'code' => 'pubg-mobile',
                'publisher' => 'Tencent',
                'target_endpoint' => 'pubgm',
                'thumbnail' => '/images/logo/pubgm.png',
                'banner' => '/images/banner/pubgm.jpg',
            ],
            [
                'name' => 'Genshin Impact',
                'code' => 'genshin-impact',
                'publisher' => 'Hoyoverse',
                'target_endpoint' => 'gi',
                'thumbnail' => '/images/logo/genshin.png',
                'banner' => '/images/banner/genshin.jpg',
            ],
            // Tambahkan game lain jika sudah download gambarnya
        ];

        DB::table('games')->insert($games);
    }
}