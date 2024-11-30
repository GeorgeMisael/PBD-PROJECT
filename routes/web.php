<?php

use App\Http\Controllers;
use App\Http\Controllers\PenerimaanController;
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
Route::post('/vendor/store', [Controllers\VendorController::class,'store'])->name('vendor.store');
Route::get('/vendor/inactive/{id}', [Controllers\VendorController::class,'inactive'])->name('vendor.inactive');
Route::get('/vendor/inactive', [Controllers\VendorController::class, 'inactiveList'])->name('vendor.inactive.list');
Route::get('/vendor/inactive/edit/{id}', [Controllers\VendorController::class, 'edit'])->name('vendor.edit');
Route::post('/vendor/inactive/update/{id}', [Controllers\VendorController::class, 'update'])->name('vendor.update');
Route::get('/vendor/active/{id}', [Controllers\VendorController::class, 'active'])->name('vendor.active');

// Satuan
Route::get('/satuan', [Controllers\SatuanController::class, 'index'])->name('satuan');
Route::get('/satuan/create', [Controllers\SatuanController::class,'create'])->name('satuan.create');
Route::post('/satuan/store', [Controllers\SatuanController::class,'store'])->name('satuan.store');
Route::get('/satuan/inactive/{id}', [Controllers\SatuanController::class,'inactive'])->name('satuan.inactive');
Route::get('/satuan/inactive', [Controllers\SatuanController::class, 'inactiveList'])->name('satuan.inactive.list');
Route::get('/satuan/active/{id}', [Controllers\SatuanController::class, 'active'])->name('satuan.active');
Route::get('/satuan/inactive/edit/{id}', [Controllers\SatuanController::class, 'edit'])->name('satuan.edit');
Route::post('/satuan/inactive/update/{id}', [Controllers\SatuanController::class, 'update'])->name('satuan.update');

// Barang
Route::get('/barang', [Controllers\BarangController::class, 'index'])->name('barang');
Route::get('/barang/create', [Controllers\BarangController::class,'create'])->name('barang.create');
Route::post('/barang/store', [Controllers\BarangController::class,'store'])->name('barang.store');
Route::get('/barang/inactive/{id}', [Controllers\BarangController::class,'inactive'])->name('barang.inactive');
Route::get('/barang/inactive', [Controllers\BarangController::class,'inactivelist'])->name('barang.inactivelist');
Route::get('/barang/active/{id}', [Controllers\BarangController::class, 'active'])->name('barang.active');
Route::get('/barang/inactive/edit/{id}', [Controllers\BarangController::class, 'edit'])->name('barang.edit');
Route::post('/barang/update/{id}', [Controllers\BarangController::class, 'update'])->name('barang.update');

// Pengadaan
Route::get('/pengadaan', [Controllers\PengadaanController::class, 'index'])->name('pengadaan');
Route::post('/pengadaan/store', [Controllers\PengadaanController::class,'store'])->name('pengadaan.store');
Route::get('/pengadaan/delete/{id}', [Controllers\PengadaanController::class, 'destroy'])->name('pengadaan.destroy');
Route::post('/pengadaan/complete', [Controllers\PengadaanController::class, 'complete'])->name('pengadaan.complete');


// penerimaan
Route::post('/penerimaan', [PenerimaanController::class, 'store'])->name('penerimaan');

// Kartu Stok
Route::get('/kartustok', [Controllers\KartuStokController::class, 'index'])->name('kartustok');
