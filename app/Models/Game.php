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
        'publisher',
        'target_endpoint',
        'thumbnail',
        'banner',
    ];

    /**
     * Relasi ke Product (One to Many)
     * [PERBAIKAN] Kita definisikan manual foreign key & local key-nya
     * foreign_key: 'game_code' (ada di tabel products)
     * local_key: 'code' (ada di tabel games)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'game_code', 'code');
    }
}