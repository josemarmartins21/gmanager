<?php

namespace App\Services\permissions;

use App\Models\Permission;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use Illuminate\Database\Eloquent\Collection;

class PermissionService implements PermissionInterface
{
    public function all(): Collection
    {
        try {
            
            return Permission::all('name', 'id');
        } catch (\Throwable) {
            throw new \Exception("Erro ao registar o usuário");
            
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
            throw new \Exception("Erro ao associar a permissão");
            
        }
    }

    public function revoke(User $user, string $permission): void
    {
        try {
            
            $user->revokePermissionTo($permission);

        } catch (\Throwable) {
            throw new \Exception("Erro ao revogar a permissão");
        }
    }
}