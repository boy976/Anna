<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BarangController;

Route::get('/', [BarangController::class, 'dashboard']);

Route::get('/stok-barang', [BarangController::class, 'index']);
Route::get('/stok-barang/create', [BarangController::class, 'create']);
Route::post('/stok-barang', [BarangController::class, 'store']);

Route::get('/stok-barang/edit/{id}', [BarangController::class, 'edit']);
Route::post('/stok-barang/update/{id}', [BarangController::class, 'update']);

Route::post('/stok-barang/keluar', [BarangController::class, 'keluar']);
Route::post('/stok-barang/masuk', [BarangController::class, 'masuk']);
Route::post('/stok-barang/masuk/{id}', [BarangController::class, 'masukById']);

Route::delete('/stok-barang/{id}', [BarangController::class, 'destroy']);
Route::get('/transaksi', [BarangController::class, 'transaksi']);
Route::post('/transaksi/cancel/{id}', [BarangController::class, 'cancelTransaksi']);
