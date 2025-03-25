<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function () {
    Route::resource('products', ProductsController::class);
})->middleware(['auth', 'verified']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
