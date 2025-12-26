<?php

use Illuminate\Support\Facades\Route;

// Import Models
use App\Models\Game;

// Import Public Controllers
use App\Http\Controllers\TopupController;
use App\Http\Controllers\OrderController; // <--- SUDAH DIAKTIFKAN

// Import Admin Controllers
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC ROUTES (Halaman Depan / Member)
// ==========================================

Route::get('/', function () {
    $games = Game::all();
    return view('home', compact('games'));
})->name('home');

// Halaman Top Up
Route::get('/topup/{slug}', [TopupController::class, 'index'])->name('topup.index');
Route::post('/topup/process', [TopupController::class, 'process'])->name('topup.process');
Route::post('/api/check-game-id', [TopupController::class, 'checkGameId'])->name('api.checkGameId');

// Halaman Cek Pesanan (SUDAH DIAKTIFKAN)
Route::get('/order/check', [OrderController::class, 'index'])->name('order.check');
Route::post('/order/check', [OrderController::class, 'search'])->name('order.search');


// ==========================================
// 2. ADMIN ROUTES (Panel Belakang)
// ==========================================

// A. GUEST ADMIN
Route::prefix('admin')->middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'loginView'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
});

// B. AUTH ADMIN
Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    
    // --- AUTH ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // --- MANAJEMEN USER ---
    Route::resource('users', UserController::class, ['as' => 'admin']);

    // --- MONITORING TRANSAKSI ---
    Route::resource('transactions', TransactionController::class, ['as' => 'admin'])->only(['index', 'update']);

    // --- MANAJEMEN GAME ---
    Route::resource('games', GameController::class, ['as' => 'admin'])->except(['create', 'edit', 'show']);

    // --- MANAJEMEN PRODUK ---
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/sync', [ProductController::class, 'syncView'])->name('admin.products.sync');
    Route::post('/products/sync', [ProductController::class, 'syncProcess'])->name('admin.products.sync.process');

    // --- INTEGRASI API ---
    Route::get('/integration/digiflazz', [IntegrationController::class, 'digiflazz'])->name('admin.integration.digiflazz');
    Route::post('/integration/digiflazz', [IntegrationController::class, 'updateDigiflazz'])->name('admin.integration.digiflazz.update');
    Route::post('/integration/digiflazz/check', [IntegrationController::class, 'checkDigiflazz'])->name('admin.integration.digiflazz.check');

    Route::get('/integration/tripay', [IntegrationController::class, 'tripay'])->name('admin.integration.tripay');
    Route::post('/integration/tripay', [IntegrationController::class, 'updateTripay'])->name('admin.integration.tripay.update');
    Route::post('/integration/tripay/check', [IntegrationController::class, 'checkTripay'])->name('admin.integration.tripay.check');

    // --- SETTING ---
    Route::get('/config/web', function() { return "<h3>Halaman Konfigurasi Website</h3><p>Fitur ganti nama web, logo, & warna (Coming Soon).</p>"; })->name('admin.config.web');
    Route::get('/config/server', [ServerController::class, 'index'])->name('admin.config.server');
    Route::post('/config/server/clear', [ServerController::class, 'clearCache'])->name('admin.server.clear');
    Route::post('/config/server/maintenance', [ServerController::class, 'toggleMaintenance'])->name('admin.server.maintenance');

    // --- PROMO ---
    Route::get('/promos', [PromoController::class, 'index'])->name('admin.promos.index');
    Route::post('/promos', [PromoController::class, 'store'])->name('admin.promos.store');
    Route::delete('/promos/{id}', [PromoController::class, 'destroy'])->name('admin.promos.destroy');
    Route::post('/promos/{id}/toggle', [PromoController::class, 'toggle'])->name('admin.promos.toggle');

});