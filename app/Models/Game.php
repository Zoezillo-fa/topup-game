<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'publisher',        // Tambahkan ini (ada di migration)
        'brand_digiflazz',
        'target_endpoint',  // <--- WAJIB ADA (Sesuai migration user)
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