<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');


Route::get('/vendor', [Controllers\VendorController::class, 'index'])->name('vendor');