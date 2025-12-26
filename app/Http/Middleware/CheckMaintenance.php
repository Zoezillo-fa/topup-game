<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika mode maintenance AKTIF
        if (\App\Models\Configuration::getBy('is_maintenance') == 'true') {
            // Jika user BUKAN admin, tampilkan error 503
            if (!$request->user() || $request->user()->role !== 'admin') {
                // Kecuali halaman login admin, blokir semua
                if (!$request->is('admin/*')) {
                    abort(503, 'Website Sedang Dalam Perbaikan (Maintenance).');
                }
            }
        }
        return $next($request);
    }
}
