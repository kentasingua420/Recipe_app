<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin@gmail.com'),
                'is_admin' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'kent@gmail.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('kent@gmail.com'),
                'is_admin' => 0,
            ]
        );
    }
}