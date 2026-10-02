<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            // Settings
            'settings-view',
            'settings-update',
            
            // Users
            'users-view',
            'users-create',
            'users-update',
            'users-delete',
            
            // Roles
            'roles-view',
            'roles-create',
            'roles-update',
            'roles-delete',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Super Admin role and give all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());
    }
}
