<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed roles, permissions, and the default admin user.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'list-branch',
            'create-branch',
            'edit-branch',
            'delete-branch',
            'list-student',
            'create-student',
            'edit-student',
            'delete-student',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staffRole->syncPermissions([
            'list-student',
            'create-student',
            'edit-student',
            'list-branch',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $staff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $staff->hasRole('staff')) {
            $staff->assignRole('staff');
        }
    }
}
