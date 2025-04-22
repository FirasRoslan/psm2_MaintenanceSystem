<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\House;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $house = House::first();

        $roomTypes = ['Living Room', 'Master Bedroom', 'Kitchen'];

        foreach ($roomTypes as $type) {
            Room::create([
                'houseID' => $house->houseID,
                'room_type' => $type,
                'room_image' => 'rooms/default-room.jpg'
            ]);
        }
    }
}