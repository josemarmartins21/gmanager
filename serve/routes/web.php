<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductExcludedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\StockMovementController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stock-movements', StockMovementController::class)->except(['destroy', 'show']);
    
    Route::prefix('lixeira')->group(function() {
        Route::get('products', [ProductExcludedController::class, 'index'])->name('products-recycle.index');
        Route::post('products/{id}/restore', [ProductExcludedController::class, 'restore'])->name('products-recycle.restore');
        Route::post('products/restore-all', [ProductExcludedController::class, 'restoreAll'])->name('products-recycle.restoreAll');
        Route::post('products/clean-all', [ProductExcludedController::class, 'destroyAll'])->name('products-recycle.cleanAll');
        Route::delete('products/{id}/delete-permanently', [ProductExcludedController::class, 'destroy'])
        ->name('products-recycle.forceDelete');
    });
    
    Route::prefix('pdfs')->group(function() {
        Route::get('{typePdf}', [PdfController::class, 'download']);
    });
    
    Route::resource('sales', SaleController::class)->except(['update', 'edit']);
    
    Route::prefix('sale-items')->group(function() {
        Route::get('items/{id}', [SaleItemController::class, 'show']);
        Route::post('items/{product}', [SaleItemController::class, 'store']);
        Route::post('flush-all', [SaleItemController::class, 'removeAll']);
        Route::post('flush', [SaleItemController::class, 'destroy']);
        Route::get('items', [SaleItemController::class, 'index']);
    
    });
    
    Route::get('/', HomeController::class)->name('home');
});



Route::prefix('admin')->middleware('auth')->group(function() {
    Route::middleware('can:admin')->group(function () {
        Route::get('/dashboard', function () {
            $users = User::select('name', 'email', 'id')->orderByDesc('created_at')->paginate(10);
        
            return view('dashboard', compact('users'));
        
        })->middleware(['verified'])->name('dashboard');
    
        Route::get('/profile/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
        // Permissões
        Route::post('revoke-permission/{user}', [PermissionController::class, 'revokePermission'])->name('permission.revoke');
        Route::post('give-permission/{user}', [PermissionController::class, 'joinPermission'])->name('permission.give');
    
    });
});

require __DIR__.'/auth.php';
