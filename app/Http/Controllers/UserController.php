<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Traits\UploadsImage;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use UploadsImage;

    public function index()
    {
        Gate::authorize('users-view');

        $users = User::with('roles')->orderBy('id', 'DESC')->get();
        $roles = Role::all();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('users-create');

        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:8|max:100',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|regex:/^[0-9]{7,15}$/',
        ], [
            'phone.regex' => 'The phone number must contain only numbers and be between 7 to 15 digits long.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? 1,
        ]);

        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('users-update');

        $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:100',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|regex:/^[0-9]{7,15}$/',
        ], [
            'phone.regex' => 'The phone number must contain only numbers and be between 7 to 15 digits long.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? 1,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        Gate::authorize('users-delete');

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself!');
        }

        $this->deleteImage($user->image);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
