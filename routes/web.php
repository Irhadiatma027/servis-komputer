<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/barang',\App\Http\Controllers\barangController::class);
Route::resource('/customers',\App\Http\Controllers\customersController::class);
Route::resource('/supplier',\App\Http\Controllers\supplierController::class);

Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
