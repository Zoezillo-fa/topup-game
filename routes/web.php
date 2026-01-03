<?php

use Illuminate\Support\Facades\Route;

// Import Models
use App\Models\Game;
use App\Models\Promo;

// Import Public/Member Controllers
use App\Http\Controllers\TopupController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\PageController;

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
use App\Http\Controllers\Admin\PaymentMethodController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC & MEMBER ROUTES
// ==========================================

Route::get('/', function () {
    // Hanya tampilkan game yang aktif di halaman depan
    $games = Game::where('is_active', 1)->get(); 
    return view('home', compact('games'));
})->name('home');

// Route Halaman Pricelist
Route::get('/pricelist', [PricelistController::class, 'index'])->name('pricelist');

// ==========================================
// HALAMAN INFORMASI & FITUR (FOOTER MENU)
// ==========================================
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/privacy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('page.terms');
Route::get('/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('/leaderboard', [PageController::class, 'leaderboard'])->name('page.leaderboard');
Route::get('/calculator', [PageController::class, 'calculator'])->name('page.calculator');
Route::get('/check-region', [PageController::class, 'regionCheck'])->name('page.region');
Route::get('/join-reseller', [PageController::class, 'reseller'])->name('page.reseller');

// AUTH MEMBER (Login & Register Biasa)
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// HALAMAN TOP UP & ORDER
// ==========================================

// Redirect /topup ke Home (Mencegah 404 jika slug kosong)
Route::get('/topup', function() {
    return redirect()->route('home');
});

// Halaman Detail Game (Contoh: /topup/mobile-legends)
Route::get('/topup/{slug}', [TopupController::class, 'index'])->name('topup.index');

// Batasi maksimal 10 request per 1 menit untuk order
Route::middleware(['throttle:10,1'])->post('/topup/process', [TopupController::class, 'process'])->name('topup.process');

// Batasi maksimal 30 request per 1 menit untuk cek ID (Mencegah spam API Apigames)
Route::middleware(['throttle:30,1'])->post('/api/check-game-id', [TopupController::class, 'checkGameId'])->name('api.checkGameId');

// Cek Pesanan / Invoice
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
    
    // --- MANAJEMEN USER & TRANSAKSI ---
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::resource('transactions', TransactionController::class, ['as' => 'admin'])->only(['index', 'update']);
    Route::post('/users/{id}/balance', [UserController::class, 'updateBalance'])->name('admin.users.balance');
    
    // --- MANAJEMEN GAME ---
    Route::resource('games', GameController::class, ['as' => 'admin'])->except(['create', 'show']);
    // Route Sync Game dari Digiflazz
    Route::post('/games/sync-digiflazz', [GameController::class, 'syncDigiflazz'])->name('admin.games.sync');

    // --- MANAJEMEN PRODUK ---
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/sync', [ProductController::class, 'syncView'])->name('admin.products.sync');
    Route::post('/products/sync', [ProductController::class, 'syncProcess'])->name('admin.products.sync.process');
    
    // Route Sync Produk Otomatis & Cek Brand
    Route::post('/products/sync-all', [ProductController::class, 'syncAllProcess'])->name('admin.products.sync.all');
    Route::get('/products/check-brands', [ProductController::class, 'getDigiflazzBrands'])->name('admin.products.brands');

    // --- INTEGRASI (API) ---
    
    // 1. Digiflazz (Stok)
    Route::get('/integration/digiflazz', [IntegrationController::class, 'digiflazz'])->name('admin.integration.digiflazz');
    Route::post('/integration/digiflazz', [IntegrationController::class, 'updateDigiflazz'])->name('admin.integration.digiflazz.update');
    Route::post('/integration/digiflazz/check', [IntegrationController::class, 'checkDigiflazz'])->name('admin.integration.digiflazz.check');

    // 2. Tripay (Payment Gateway)
    Route::get('/integration/tripay', [IntegrationController::class, 'tripay'])->name('admin.integration.tripay');
    Route::post('/integration/tripay', [IntegrationController::class, 'updateTripay'])->name('admin.integration.tripay.update');
    Route::post('/integration/tripay/check', [IntegrationController::class, 'checkTripay'])->name('admin.integration.tripay.check');

    // 3. Xendit (Payment Gateway) [BARU]
    Route::get('/integration/xendit', [IntegrationController::class, 'xendit'])->name('admin.integration.xendit');
    Route::post('/integration/xendit', [IntegrationController::class, 'updateXendit'])->name('admin.integration.xendit.update');
    Route::post('/integration/xendit/check', [IntegrationController::class, 'checkXendit'])->name('admin.integration.xendit.check');

    // 4. Apigames (Cek ID Game)
    Route::get('/integration/apigames', [IntegrationController::class, 'apigames'])->name('admin.integration.apigames');
    Route::post('/integration/apigames', [IntegrationController::class, 'updateApigames'])->name('admin.integration.apigames.update');
    Route::post('/integration/apigames/check', [IntegrationController::class, 'checkApigames'])->name('admin.integration.apigames.check');

    // 5. Metode Pembayaran (Multi-Gateway) [UPDATED]
    Route::get('/integration/payment', [PaymentMethodController::class, 'index'])->name('admin.integration.payment');
    
    // Simpan Manual
    Route::post('/integration/payment', [PaymentMethodController::class, 'store'])->name('admin.integration.payment.store'); 
    // Update Data
    Route::put('/integration/payment/{id}', [PaymentMethodController::class, 'update'])->name('admin.integration.payment.update');
    
    // [BARU] Update Status Gateway (Enable/Disable)
    Route::post('/integration/payment/status', [PaymentMethodController::class, 'updateGatewayStatus'])->name('admin.integration.payment.status');
    
    // [BARU] Sync Otomatis (Tripay & Xendit)
    Route::post('/integration/payment/sync-auto', [PaymentMethodController::class, 'syncAuto'])->name('admin.integration.payment.sync');
   
    // --- CONFIG WEB (Logo, Nama, Footer) ---
    Route::get('/config/web', [ServerController::class, 'webView'])->name('admin.config.web');
    Route::post('/config/web', [ServerController::class, 'updateWeb'])->name('admin.config.web.update');

    // --- CONFIG SERVER ---
    Route::get('/config/server', [ServerController::class, 'index'])->name('admin.config.server');
    Route::post('/config/server/clear', [ServerController::class, 'clearCache'])->name('admin.server.clear');
    Route::post('/config/server/maintenance', [ServerController::class, 'toggleMaintenance'])->name('admin.server.maintenance');

    // --- PROMO / BANNER ---
    Route::get('/promos', [PromoController::class, 'index'])->name('admin.promos.index');
    Route::post('/promos', [PromoController::class, 'store'])->name('admin.promos.store');
    Route::delete('/promos/{id}', [PromoController::class, 'destroy'])->name('admin.promos.destroy');
    Route::post('/promos/{id}/toggle', [PromoController::class, 'toggle'])->name('admin.promos.toggle');

});

// ==========================================
// 3. MEMBER AREA (Profil & Setting)
// ==========================================
Route::middleware(['auth'])->group(function() {
    
    // Halaman Profil
    Route::get('/member/profile', [MemberController::class, 'index'])->name('member.profile');

    // FITUR DEPOSIT / ISI SALDO
    Route::get('/member/deposit', [\App\Http\Controllers\Member\DepositController::class, 'index'])->name('deposit.index');
    Route::post('/member/deposit', [\App\Http\Controllers\Member\DepositController::class, 'store'])->name('deposit.store');

    // [BARU] FITUR RIWAYAT TRANSAKSI
    Route::get('/member/transactions', [\App\Http\Controllers\Member\TransactionController::class, 'index'])->name('member.transactions');
    
    // Proses Update
    Route::put('/member/profile', [MemberController::class, 'updateProfile'])->name('member.profile.update');
    Route::put('/member/password', [MemberController::class, 'updatePassword'])->name('member.password.update');

    // Upgrade VIP (Redirect ke WA Admin)
    Route::get('/member/upgrade-vip', function() {
        $phone = \App\Models\Configuration::getBy('whatsapp_number') ?? '628123456789';
        $text = "Halo Admin, saya ingin upgrade akun saya menjadi VIP Member.";
        return redirect("https://wa.me/{$phone}?text=" . urlencode($text));
    })->name('member.upgrade');

});