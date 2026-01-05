<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkRole' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        $middleware->append(\App\Http\Middleware\CheckMaintenance::class);

        // --- TAMBAHAN: EXCLUDE CSRF UNTUK CALLBACK ---
        $middleware->validateCsrfTokens(except: [
            'api/*',                // Semua route di file api.php aman
            'topup/callback/*',      // Jaga-jaga jika pakai prefix lain
            'callback/*',            // Jaga-jaga
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();