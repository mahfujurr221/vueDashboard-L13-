<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        $user = User::firstOrCreate(
            ['email' => 'tiger@gmail.com'],
            [
                'name' => 'tiger',
                'phone' => '1234567890',
                'password' => \Illuminate\Support\Facades\Hash::make('@#tiger#@'),
            ]
        );

        // Assign super-admin role
        $user->assignRole('super-admin');
    }
}
