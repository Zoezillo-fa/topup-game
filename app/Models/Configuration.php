<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Configuration extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil config dari Cache. Jika tidak ada, ambil dari DB lalu simpan ke Cache.
     */
    public static function getBy($key, $default = null)
    {
        // Cache selama 24 jam (1440 menit)
        return Cache::remember("config_{$key}", 60 * 24, function () use ($key, $default) {
            $config = self::where('key', $key)->first();
            return $config ? $config->value : $default;
        });
    }

    /**
     * [BARU] Simpan atau Update konfigurasi ke Database
     */
    public static function set($key, $value)
    {
        // Menggunakan updateOrCreate agar jika key sudah ada di-update, jika belum ada dibuat baru
        $config = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Hapus cache agar data baru langsung terbaca
        Cache::forget("config_{$key}");

        return $config;
    }

    /**
     * Hapus cache otomatis saat model di-save/delete manual
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget("config_{$model->key}");
        });

        static::deleted(function ($model) {
            Cache::forget("config_{$model->key}");
        });
    }
}