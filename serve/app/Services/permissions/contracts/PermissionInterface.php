<?php

namespace App\Services\permissions\contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PermissionInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
    */
    public function all(): Collection;

    /**
     * @return void
     * @throws \Exception
    */
    public function associate(User $user, string | array $permissions): void;  
    
    /**
     * @return void
     * @throws \Exception
    */
    public function revoke(User $user, string $permission): void;

    /**
     *  @throws \Exception
     *  @return array
     */
    public function allDefaultPermission(): array;
}