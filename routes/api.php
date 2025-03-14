<?php

use App\Http\Controllers\Api\CorporationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// @todo - Unprotected for now but will be under Sanctum Access Tokens for iOS app
Route::get('/corporations', [CorporationsController::class, 'index']);
Route::get('/corporations/{corporation}', [CorporationsController::class, 'show']);
Route::get('/corporations/{corporation}/products', [CorporationsController::class, 'indexProducts']);
Route::get('/corporations/{corporation}/products/{product}', [CorporationsController::class, 'showProduct']);
