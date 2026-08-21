<?php

namespace App\Providers;

use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use App\Services\permissions\PermissionService;
use App\Services\products\contracts\ProductInterface;
use App\Services\products\ProductService;
use App\Services\Sales\CartSessionService;
use App\Services\Sales\Contracts\CartSessionInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin-access', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
