<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'is_admin' => 1,
        ]);

        // Create regular test user
        User::create([
            'name' => 'Regular User',
            'email' => 'kent@gmail.com',
            'password' => Hash::make('kent@gmail.com'),
            'is_admin' => 0,
        ]);
    }
}