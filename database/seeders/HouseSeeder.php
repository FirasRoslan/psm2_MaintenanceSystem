<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        $landlord = User::where('role', 'landlord')->first();

        House::create([
            'userID' => $landlord->userID,
            'house_address' => '123 Main Street, City',
            'house_number_room' => 3,
            'house_number_toilet' => 2,
            'house_image' => 'houses/default-house.jpg'
        ]);
    }
}