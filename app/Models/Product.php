<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 
    'code', 
    'game_code', 
    'price', 
    'sku_provider', 
    'cost_price', 
    'is_active',
    'category' // <--- TAMBAHKAN INI
];
}