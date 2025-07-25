<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view dashboard',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view articles', 'create articles', 'edit articles', 'delete articles',
            'view tickets', 'create tickets', 'edit tickets', 'delete tickets', 'reply tickets',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
    }
}