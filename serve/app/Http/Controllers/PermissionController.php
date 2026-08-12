<?php

namespace App\Http\Controllers;

use App\Http\Requests\permissions\PermissionRequest;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;

class PermissionController extends Controller
{
    public function __construct(
        private PermissionInterface $permissionService
    )
    {}

    public function joinToPermission(User $user, PermissionRequest $request)
    {
        try {
            
            $this->permissionService->associate($user, $request->permission);

            return redirect()->back()->with('success', 'Permissão associada com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function revokePermission(User $user, PermissionRequest $request)
    {
        try {

            $this->permissionService->revoke($user, $request->permission);

            return redirect()->back()->with('success', 'Permissão revogada com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}