<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExcludedController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('stock-movements', StockMovementController::class)->except(['destroy', 'show']);

Route::prefix('lixeira')->group(function() {
    Route::get('products', [ProductExcludedController::class, 'index']);
    Route::post('products/{id}/restore', [ProductExcludedController::class, 'restore']);
    Route::post('products/restore-all', [ProductExcludedController::class, 'restoreAll']);
    Route::post('products/clean-all', [ProductExcludedController::class, 'destroyAll']);
    Route::delete('products/{id}/delete-permanently', [ProductExcludedController::class, 'destroy']);
});