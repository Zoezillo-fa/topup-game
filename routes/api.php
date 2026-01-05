<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameCheckController;
use App\Http\Controllers\Api\CallbackController; // <--- Pastikan di-import

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// API Cek ID Game (Public)
Route::post('/check-game-id', [GameCheckController::class, 'check'])->name('api.check.game');

// ==========================================
// ROUTES CALLBACK PAYMENT GATEWAY
// ==========================================

// 1. Callback Tripay
Route::post('/callback/tripay', [CallbackController::class, 'handleTripay']);

// 2. Callback Xendit
Route::post('/callback/xendit', [CallbackController::class, 'handleXendit']);

// 3. Callback Midtrans (WAJIB ADA)
Route::post('/callback/midtrans', [CallbackController::class, 'handleMidtrans']);