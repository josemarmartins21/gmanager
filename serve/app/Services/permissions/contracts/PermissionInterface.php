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
     * @return array
     */
    public function allPermissionName(): array;

    /**
     * @return void
     * @throws \Exception
     */
    public function associate(User $user, $permissions = []): void;                 
}