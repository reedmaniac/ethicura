<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function() {


})->middleware(['auth', 'verified']);



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
