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
        $this->call(PermissionSeeder::class);
    
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);
    
        // Assign all permissions to admin
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));
    
        // Staff hanya beberapa
        $staffRole->permissions()->sync(
            Permission::whereIn('name', [
                'view tickets',
                'reply tickets',
            ])->pluck('id')
        );
    
        // Create users
        User::create([
            'name' => 'Admin Keloola',
            'email' => 'admin@keloola.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);
    
        User::create([
            'name' => 'Staff Keloola',
            'email' => 'staff@keloola.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id
        ]);
    }
    
    
}
