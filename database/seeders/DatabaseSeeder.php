<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);

        // Seed Permissions
        $permissions = [
            'manage_users',
            'manage_tickets',
            'view_reports',
            'manage_articles',
            'manage_departments',
        ];
        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Assign all permissions to admin, some to staff
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));
        $staffRole->permissions()->sync(Permission::whereIn('name', ['manage_tickets', 'manage_articles'])->pluck('id'));

        // Create users
        $admin = User::create([
            'name' => 'Admin Keloola',
            'email' => 'admin@keloola.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);
        $staff = User::create([
            'name' => 'Staff Keloola',
            'email' => 'staff@keloola.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id
        ]);
    }
    
}
