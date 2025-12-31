<?php

use Illuminate\Support\Facades\Route;

// Import Models
use App\Models\Game;

// Import Public/Member Controllers
use App\Http\Controllers\TopupController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\AuthController;

// Import Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
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
// 1. PUBLIC & MEMBER ROUTES
// ==========================================

Route::get('/', function () {
    $games = Game::all();
    return view('home', compact('games'));
})->name('home');

// AUTH MEMBER (Login & Register Biasa)
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// HALAMAN TOP UP & ORDER
Route::get('/topup/{slug}', [TopupController::class, 'index'])->name('topup.index');
Route::post('/topup/process', [TopupController::class, 'process'])->name('topup.process');
Route::post('/api/check-game-id', [TopupController::class, 'checkGameId'])->name('api.checkGameId');

Route::get('/order/check', [OrderController::class, 'index'])->name('order.check');
Route::post('/order/check', [OrderController::class, 'search'])->name('order.search');


// ==========================================
// 2. ADMIN PANEL ROUTES
// ==========================================

Route::redirect('/admin', '/admin/login');

// A. GUEST ADMIN (Login Khusus Admin)
Route::prefix('admin')->middleware('guest')->group(function() {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::get('/register', [AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'registerProcess'])->name('admin.register.process');
});

// B. AUTH ADMIN (Dashboard & Kelola Data)
Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Fitur Kelola
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::resource('transactions', TransactionController::class, ['as' => 'admin'])->only(['index', 'update']);
    Route::resource('games', GameController::class, ['as' => 'admin'])->except(['create', 'edit', 'show']);
    
    // Produk
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/sync', [ProductController::class, 'syncView'])->name('admin.products.sync');
    Route::post('/products/sync', [ProductController::class, 'syncProcess'])->name('admin.products.sync.process');

    // Integrasi
    Route::get('/integration/digiflazz', [IntegrationController::class, 'digiflazz'])->name('admin.integration.digiflazz');
    Route::post('/integration/digiflazz', [IntegrationController::class, 'updateDigiflazz'])->name('admin.integration.digiflazz.update');
    Route::post('/integration/digiflazz/check', [IntegrationController::class, 'checkDigiflazz'])->name('admin.integration.digiflazz.check');

    Route::get('/integration/tripay', [IntegrationController::class, 'tripay'])->name('admin.integration.tripay');
    Route::post('/integration/tripay', [IntegrationController::class, 'updateTripay'])->name('admin.integration.tripay.update');
    Route::post('/integration/tripay/check', [IntegrationController::class, 'checkTripay'])->name('admin.integration.tripay.check');

    // --- [PERBAIKAN] Rute Config Web Ditambahkan Kembali ---
    Route::get('/config/web', function() { 
        return "<h3>Halaman Konfigurasi Website</h3><p>Fitur ganti nama web, logo, & warna (Coming Soon).</p>"; 
    })->name('admin.config.web');

    // Setting Server
    Route::get('/config/server', [ServerController::class, 'index'])->name('admin.config.server');
    Route::post('/config/server/clear', [ServerController::class, 'clearCache'])->name('admin.server.clear');
    Route::post('/config/server/maintenance', [ServerController::class, 'toggleMaintenance'])->name('admin.server.maintenance');

    // Promo
    Route::get('/promos', [PromoController::class, 'index'])->name('admin.promos.index');
    Route::post('/promos', [PromoController::class, 'store'])->name('admin.promos.store');
    Route::delete('/promos/{id}', [PromoController::class, 'destroy'])->name('admin.promos.destroy');
    Route::post('/promos/{id}/toggle', [PromoController::class, 'toggle'])->name('admin.promos.toggle');

});