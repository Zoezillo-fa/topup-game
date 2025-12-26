<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos'; // Pastikan nama tabel benar

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_usage',
        'is_active',
    ];
}