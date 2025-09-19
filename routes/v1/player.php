<?php

use App\Http\Controllers\Api\v1\Admin\LotteryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\WalletController;
use App\Http\Controllers\Api\v1\BetController;




Route::group(['prefix' => 'player',], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('wallet', [WalletController::class, 'show']);
        Route::post('bets', [BetController::class, 'place']);
    });
});
