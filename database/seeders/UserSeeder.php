<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Landlord User',
            'email' => 'landlord@example.com',
            'password' => Hash::make('password123'),
            'role' => 'landlord',
            'approval' => true
        ]);

        User::create([
            'name' => 'Tenant User',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'approval' => true
        ]);

        User::create([
            'name' => 'Contractor User',
            'email' => 'contractor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'contractor',
            'approval' => true
        ]);
    }
}