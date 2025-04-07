<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('quick-product', [DashboardController::class, 'storeQuickProduct'])->name('quick-product');
    Route::post('quick-corporation', [DashboardController::class, 'storeQuickCorporation'])->name('quick-corporation');

    Route::resource('products', ProductsController::class)->except('show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
