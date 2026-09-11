<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Services\permissions\contracts\PermissionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(
        private PermissionInterface $permissionService
    )
    {}
    
    /**
     * Display the registration view.
     */
    public function create(): View | RedirectResponse
    {
        try {
            $permissions = $this->permissionService->all();
    
            return view('auth.register', compact('permissions'));
            
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $permissionsName = Permission::all()->pluck('name')->toArray();
    
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required','confirmed',  Rules\Password::defaults()],
                'permissions[]' => ['nullable', Rule::in($permissionsName), 'array']
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            if ($request->permissions) {
                $this->permissionService->associate($user, $request->permissions);
            }
    
            return redirect(route('dashboard', absolute: false));
         
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
