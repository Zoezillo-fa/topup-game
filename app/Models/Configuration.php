<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['key', 'value'];

    // Cara ambil: Configuration::getBy('tripay_api_key')
    public static function getBy($key) {
        return self::where('key', $key)->value('value');
    }

    // Cara simpan: Configuration::set('tripay_api_key', '12345')
    public static function set($key, $value) {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}