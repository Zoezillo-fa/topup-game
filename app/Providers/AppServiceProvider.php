<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\PaymentMethod;
use App\Models\Configuration;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mengirim data konfigurasi dan metode pembayaran ke semua view
        // Gunakan try-catch agar tidak error saat pertama kali migrate
        try {
            $config = Configuration::first();
            $payment_methods = PaymentMethod::where('is_active', 1)->get();
            
            View::share('config', $config);
            View::share('payment_methods', $payment_methods);
        } catch (\Exception $e) {
            // Do nothing
        }
    }
}