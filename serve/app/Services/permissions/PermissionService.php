<?php

namespace App\Services\permissions;

use App\Models\Permission;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PermissionService implements PermissionInterface
{
    public function all(): Collection
    {
        try {

            return Permission::all('name', 'id');
            
        } catch (\Throwable) {
            throw new \Exception("Não foi possível carregar as permissões. Por favor, tente novamente.");
            
        }
    }

    public function associate(User $user, string | array $permissions): void
    {
        try {

            if (is_string($permissions)) {
                $user->givePermissionTo($permissions);
                return;
            }

            foreach ($permissions as $permission) {
                $user->givePermissionTo($permission);
            }

        } catch (\Throwable) {
            throw new \Exception("Não foi possível atribuir a permissão. Por favor, tente novamente.");
        }
    }

    public function allDefaultPermission(): array
    {
        try {

            $permissionsName = Permission::all()->pluck('name')->toArray();
            $allDefaultPermission = [];

            foreach ($permissionsName as $permission) {
                if (Str::contains($permission, 'read')) {
                    $allDefaultPermission[] = $permission;
                }
            }

            return $allDefaultPermission;

        } catch (\Throwable) {
            throw new \Exception("Não foi possível carregar as permissões padrão. Por favor, tente novamente.");
        }
    }

    public function revoke(User $user, string $permission): void
    {
        try {
            
            $user->revokePermissionTo($permission);

        } catch (\Throwable) {
            throw new \Exception("Não foi possível retirar a permissão. Por favor, tente novamente.");
        }
    }
}