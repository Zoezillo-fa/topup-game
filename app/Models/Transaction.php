<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference', 'user_id_game', 'nickname_game', 'product_code', 
        'amount', 'status', 'tripay_reference', 'processing_status'
    ];
}