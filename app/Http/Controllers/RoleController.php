<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        Gate::authorize('roles-view');
        
        $roles = Role::orderBy('id', 'ASC')->get();
        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('roles-create');

        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    public function update(Request $request, Role $role)
    {
        Gate::authorize('roles-update');

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        if ($role->name === 'super-admin') {
            return redirect()->back()->with('error', 'Super Admin role cannot be modified!');
        }

        $role->update(['name' => $request->name]);

        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('roles-delete');

        if ($role->name === 'super-admin') {
            return redirect()->back()->with('error', 'Super Admin role cannot be deleted!');
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully!');
    }

    public function permissions(Role $role)
    {
        Gate::authorize('roles-update');

        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin has all permissions implicitly.');
        }

        $permissions = Permission::all();
        
        // Group permissions by prefix (e.g. "user-create" -> group "user")
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        });

        // Get currently assigned permissions as an array of names
        $rolePermissions = DB::table("role_has_permissions")
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where("role_has_permissions.role_id", $role->id)
            ->pluck('permissions.name')
            ->all();

        return Inertia::render('Roles/Permissions', [
            'role' => $role,
            'groupedPermissions' => $groupedPermissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        Gate::authorize('roles-update');

        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin has all permissions implicitly.');
        }

        $request->validate([
            'permissions' => 'nullable|array'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Permissions updated successfully!');
    }
}
