<?php

namespace App\Trait;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

trait PermissionTrait
{
    public function hasAuthorization(string $permission): void
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can($permission));
        } catch (\Throwable) {
            throw new \Exception("Você não tem permissão para " . $permission . '.');
        }
    }

    public function isAdmin()
    {
        try {
            Gate::allowIf(fn (User $user) => $user->hasRole('admin'));
        } catch (\Throwable) {
            throw new \Exception("Area restrita para administradores.");
        }
    }
}
