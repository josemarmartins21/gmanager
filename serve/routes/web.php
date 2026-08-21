<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleItemController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::select('name', 'email', 'id')->orderByDesc('created_at')->paginate(10);

    return view('dashboard', compact('users'));

})->middleware(['auth', 'verified', 'can:admin-access'])->name('dashboard');

Route::prefix('sale-items')->group(function() {
    Route::get('items/{id}', [SaleItemController::class, 'show']);
    Route::post('items/{product}', [SaleItemController::class, 'store']);
    Route::post('flush-all', [SaleItemController::class, 'removeAll']);
    Route::post('flush', [SaleItemController::class, 'destroy']);
    Route::get('items', [SaleItemController::class, 'index']);

});

Route::middleware(['auth', 'can:admin-access'])->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permissões
    Route::post('revoke-permission/{user}', [PermissionController::class, 'revokePermission'])->name('permission.revoke');
    Route::post('give-permission/{user}', [PermissionController::class, 'joinPermission'])->name('permission.give');

});

require __DIR__.'/auth.php';
