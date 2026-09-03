<?php

namespace App\Providers;

use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use App\Services\permissions\PermissionService;
use App\Services\products\contracts\ProductInterface;
use App\Services\products\ProductService;
use App\Services\Sales\CartSessionService;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Services\Sales\Contracts\SaleInterface;
use App\Services\Sales\SaleService;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Services\StockMovement\StockMovementService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PermissionInterface::class, 
            PermissionService::class
        );
        
        $this->app->bind(
            ProductInterface::class, 
            ProductService::class
        );
        
        $this->app->bind(
            CartSessionInterface::class, 
            CartSessionService::class
        );
        
        $this->app->bind(
            SaleInterface::class, 
            SaleService::class
        );
        
        $this->app->bind(
            StockMovementInterface::class, 
            StockMovementService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
