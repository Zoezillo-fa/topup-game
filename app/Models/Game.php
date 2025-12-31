<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    // Pastikan semua kolom ini ada di $fillable
    protected $fillable = [
        'name',
        'code',
        'slug',              // <--- WAJIB
        'brand_digiflazz',   // <--- WAJIB
        'endpoint',          // <--- WAJIB
        'thumbnail',
        'banner',
        'description',
        'target_url', 
        'is_active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'game_code', 'code');
    }
}