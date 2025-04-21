<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 landlords
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Landlord {$i}",
                'email' => "landlord{$i}@example.com",
                'password' => Hash::make('12345678'),
                'role' => 'landlord'
            ]);
        }

        // Create 10 tenants
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Tenant {$i}",
                'email' => "tenant{$i}@example.com",
                'password' => Hash::make('12345678'),
                'role' => 'tenant'
            ]);
        }

        // Create 10 contractors
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Contractor {$i}",
                'email' => "contractor{$i}@example.com",
                'password' => Hash::make('12345678'),
                'role' => 'contractor'
            ]);
        }
    }
}