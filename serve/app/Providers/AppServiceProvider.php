<?php

namespace App\Providers;

use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use App\Services\permissions\PermissionService;
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
