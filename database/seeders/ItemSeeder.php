<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {
            Item::create([
                'roomID' => $room->roomID,
                'item_type' => 'Furniture',
                'item_name' => 'Chair',
                'item_quantity' => 2,
                'item_image' => 'items/default-item.jpg'
            ]);
        }
    }
}