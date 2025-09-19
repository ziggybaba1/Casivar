<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    foreach (File::allFiles(__DIR__ . '/v1') as $route_file) {
        require $route_file->getPathname();
    }
});
