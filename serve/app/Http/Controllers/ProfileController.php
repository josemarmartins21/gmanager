<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private PermissionInterface $permissionService,
    )
    {}
    /**
     * Display the user's profile form.
     */
    public function edit(User $user): View
    {
        return view('profile.edit', [
            'user' => $user,
            'permissions' => $this->permissionService->all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(User $user, ProfileUpdateRequest $request): RedirectResponse
    {
        $user->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit', ['user' => $user])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        $qtyAvaliableAmdin = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->count();

        $userLoged = $request->user();

        if ($qtyAvaliableAmdin <= 1 && $user->hasRole('admin')) {
            return redirect()->back()->with('error', 'A sua conta não pode ser eliminada caso contrário o sistema não terá administrador');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        if ($userLoged->id === $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user->delete();

        return Redirect::to('/');
    }
}
