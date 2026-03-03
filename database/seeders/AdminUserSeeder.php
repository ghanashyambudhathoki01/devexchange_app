<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@devexchange.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Regular User',
            'email' => 'user@devexchange.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
