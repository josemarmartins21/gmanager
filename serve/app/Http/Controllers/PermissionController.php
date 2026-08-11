<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function __construct(
        private PermissionInterface $permissionService
    )
    {}

    public function joinToPermission(User $user, Request $request)
    {
        try {
            
            $permissionsName = $this->permissionService->allPermissionName();

            $request->validate([
                'permission' => ['required', 'string', Rule::in($permissionsName) ]
            ]);

            $this->permissionService->associate($user, $request->permission);

            return redirect()->back()->with('success', 'Permissão associada com sucesso!');

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
