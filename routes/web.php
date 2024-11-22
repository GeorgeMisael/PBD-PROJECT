<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');


// Role
Route::get('/role', [Controllers\RoleController::class, 'index'])->name('role');
Route::get('/role/create', [Controllers\RoleController::class,'create'])->name('role.create');
Route::post('/role/store', [Controllers\RoleController::class,'store'])->name('role.store');
Route::get('/role/{id}', [Controllers\RoleController::class, 'destroy'])->name('role.destroy');

// User
Route::get('/user', [Controllers\UserController::class, 'index'])->name('user');
Route::get('/user/create', [Controllers\UserController::class,'create'])->name('user.create');
Route::post('/user/store', [Controllers\UserController::class,'store'])->name('user.store');
Route::get('/user/{id}', [Controllers\UserController::class,'destroy'])->name('user.destroy');
Route::get('/user/edit/{id}', [Controllers\UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update/{id}', [Controllers\UserController::class, 'update'])->name('user.update');

// Vendor
Route::get('/vendor', [Controllers\VendorController::class, 'index'])->name('vendor');
Route::get('/vendor/create', [Controllers\VendorController::class,'create'])->name('vendor.create');

// Satuan
Route::get('/satuan', [Controllers\SatuanController::class, 'index'])->name('satuan');

// Barang
Route::get('/barang', [Controllers\BarangController::class, 'index'])->name('barang');

// Pengadaan
Route::get('/pengadaan', [Controllers\PengadaanController::class, 'index'])->name('pengadaan');

// Kartu Stok
Route::get('/kartustok', [Controllers\KartuStokController::class, 'index'])->name('kartustok');