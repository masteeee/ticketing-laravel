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
        $csStaffRole = Role::create(['name' => 'cs']);
        $staffRole = Role::create(['name' => 'staff']);

        // Assign all permissions to admin
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        // Staff hanya beberapa
        $staffRole->permissions()->sync(
            Permission::whereIn('name', [
                'view tickets',
                'reply tickets',
                'close tickets',
            ])->pluck('id')
        );

        // CS hanya beberapa
        $csStaffRole->permissions()->sync(
            Permission::whereIn('name', [
                'view tickets',
                'reply tickets',
                'close tickets',
                'create tickets',
                'assign tickets',
            ])->pluck('id')
        );

        // Create users
        User::create([
            'name' => 'Admin Keloola',
            'email' => 'root@thrive.co.id',
            'password' => Hash::make('root123!'),
            'role_id' => $adminRole->id
        ]);

        User::create([
            'name' => 'Retno Setiawati',
            'email' => 'mitra@brightcorporation.biz',
            'password' => Hash::make('mitra123!'),
            'role_id' => $csStaffRole->id
        ]);

        User::create([
            'name' => 'Frendi Triarista',
            'email' => 'frendi@thrive.co.id',
            'password' => Hash::make('frendi123!'),
            'role_id' => $staffRole->id
        ]);
    }
}
