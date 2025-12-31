<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar error "Add [name] to fillable" hilang
    protected $fillable = [
        'code',
        'name',
        'image',
        'flat_fee',
        'percent_fee',
        'is_active',
        'type'
    ];
}