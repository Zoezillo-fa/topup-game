<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference', // <--- Penting ditambahkan
        'service',
        'service_name',
        'target',
        'amount',
        'price',
        'status',
        'payment_method',
        'payment_provider',
        'sn', // Serial Number (biasanya diisi setelah sukses)
        'note'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}