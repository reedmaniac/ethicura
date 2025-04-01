<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('dashboard/quick-product', [DashboardController::class, 'storeQuickProduct'])->name('dashboard.quick-product');

    Route::resource('products', ProductsController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
