<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin Keloola',
            'email' => 'admin@keloola.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        
        User::create([
            'name' => 'Staff Keloola',
            'email' => 'staff@keloola.com',
            'password' => Hash::make('password'),
            'role' => 'staff'
        ]);
    }
    
}
