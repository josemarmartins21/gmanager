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

    public function allPermissionName(): array 
    {
        $permissionsName = [];
        
        foreach ($this->all() as $permission) {
            $permissionsName[] = $permission->name;
        }

        return $permissionsName;
    }

    public function associate(User $user, $permissions = []): void
    {
        try {

            foreach ($permissions as $permission) {
                $user->givePermissionTo($permission);
            }

        } catch (\Throwable) {
            throw new \Exception("Erro ao registar o usuário");
            
        }
    }
}