<?php

use Illuminate\Support\Facades\Route;

// Import Models
use App\Models\Game;

// Import Public Controllers
use App\Http\Controllers\TopupController;

// Import Admin Controllers
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\ServerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Jalur URL untuk Website Top Up & Admin Panel
|
*/

// ==========================================
// 1. PUBLIC ROUTES (Halaman Depan / Member)
// ==========================================

// Halaman Home (Landing Page) - Menampilkan Daftar Game
Route::get('/', function () {
    $games = Game::all(); // Mengambil semua game dari database
    return view('home', compact('games'));
})->name('home');

// Halaman Detail Topup (Contoh: /topup/mobile-legends)
Route::get('/topup/{slug}', [TopupController::class, 'index'])->name('topup.index');

// Proses Submit Order Topup
Route::post('/topup/process', [TopupController::class, 'process'])->name('topup.process');


// ==========================================
// 2. ADMIN ROUTES (Panel Belakang)
// ==========================================

// A. GUEST ADMIN (Halaman Login - Hanya bisa diakses jika BELUM login)
Route::prefix('admin')->middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
});

// B. AUTH ADMIN (Area Terbatas - Wajib Login & Role Admin)
Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    
    // --- AUTH ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // --- MANAJEMEN USER (CRUD) ---
    // Otomatis membuat route: index, create, store, edit, update, destroy
    Route::resource('users', UserController::class, ['as' => 'admin']);

    // --- MANAJEMEN GAME (CRUD) ---
    // Hanya index, store, update, destroy (karena create/edit pakai modal/form di index)
    Route::resource('games', GameController::class, ['as' => 'admin'])->except(['create', 'edit', 'show']);

    // --- MANAJEMEN PRODUK & SYNC ---
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    
    // Fitur Sync (Tarik Data dari Digiflazz)
    Route::get('/products/sync', [ProductController::class, 'syncView'])->name('admin.products.sync');
    Route::post('/products/sync', [ProductController::class, 'syncProcess'])->name('admin.products.sync.process');

    // --- INTEGRASI API (Digiflazz & Tripay) ---
    
    // 1. Digiflazz (Supplier)
    Route::get('/integration/digiflazz', [IntegrationController::class, 'digiflazz'])->name('admin.integration.digiflazz');
    Route::post('/integration/digiflazz', [IntegrationController::class, 'updateDigiflazz'])->name('admin.integration.digiflazz.update');
    Route::post('/integration/digiflazz/check', [IntegrationController::class, 'checkDigiflazz'])->name('admin.integration.digiflazz.check');

    // 2. Tripay (Payment Gateway)
    Route::get('/integration/tripay', [IntegrationController::class, 'tripay'])->name('admin.integration.tripay');
    Route::post('/integration/tripay', [IntegrationController::class, 'updateTripay'])->name('admin.integration.tripay.update');
    Route::post('/integration/tripay/check', [IntegrationController::class, 'checkTripay'])->name('admin.integration.tripay.check');

    // --- SETTING (Placeholder) ---
    Route::get('/config/web', function() { return "<h3>Halaman Konfigurasi Website</h3><p>Fitur ganti nama web, logo, & warna (Coming Soon).</p>"; })->name('admin.config.web');
    // SERVER CONFIGURATION
    Route::get('/config/server', [ServerController::class, 'index'])->name('admin.config.server');
    Route::post('/config/server/clear', [ServerController::class, 'clearCache'])->name('admin.server.clear');
    Route::post('/config/server/maintenance', [ServerController::class, 'toggleMaintenance'])->name('admin.server.maintenance');

    // MANAJEMEN PROMO / VOUCHER
    Route::get('/promos', [App\Http\Controllers\Admin\PromoController::class, 'index'])->name('admin.promos.index');
    Route::post('/promos', [App\Http\Controllers\Admin\PromoController::class, 'store'])->name('admin.promos.store');
    Route::delete('/promos/{id}', [App\Http\Controllers\Admin\PromoController::class, 'destroy'])->name('admin.promos.destroy');
    Route::post('/promos/{id}/toggle', [App\Http\Controllers\Admin\PromoController::class, 'toggle'])->name('admin.promos.toggle');

});