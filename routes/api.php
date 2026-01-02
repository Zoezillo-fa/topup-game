<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameCheckController;
use App\Http\Controllers\Api\CallbackController; // Import Controller

// Route untuk Cek ID Game
Route::post('/check-game-id', [GameCheckController::class, 'check']);

// ==========================================
// ROUTE CALLBACK (WEBHOOK)
// ==========================================

// URL: domain-anda.com/api/callback/tripay
Route::post('/callback/tripay', [CallbackController::class, 'handleTripay']);

// URL: domain-anda.com/api/callback/xendit
Route::post('/callback/xendit', [CallbackController::class, 'handleXendit']);