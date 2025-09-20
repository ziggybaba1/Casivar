<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\Admin\LotteryController;
use App\Http\Controllers\Api\v1\Admin\DrawController;


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::apiResource('lotteries', LotteryController::class);
        Route::post('draws/{draw}/result', [DrawController::class, 'postResult']);
    });
});
