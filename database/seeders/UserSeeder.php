<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecomstore.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample customer users
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => \Hash::make('password'),
            'role' => 'customer',
        ]);

        \App\Models\User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => \Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
