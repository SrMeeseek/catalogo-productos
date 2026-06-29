<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('products.index'));

Route::resource('brands', BrandController::class)->except('show');
Route::resource('products', ProductController::class)->except('show');
