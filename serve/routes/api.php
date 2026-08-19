<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExcludedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);


Route::prefix('lixeira')->group(function() {
    Route::get('products', [ProductExcludedController::class, 'index']);
    Route::post('products/{id}/restore', [ProductExcludedController::class, 'restore']);
    Route::post('products/clean-all', [ProductExcludedController::class, 'destroyAll']);

});