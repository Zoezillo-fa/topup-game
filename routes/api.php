<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameCheckController;

// Route untuk Cek ID Game
Route::post('/check-game-id', [GameCheckController::class, 'check']);