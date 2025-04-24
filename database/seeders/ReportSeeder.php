<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use App\Models\Room;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = User::where('role', 'tenant')->first();
        $item = Item::first();
        $room = Room::first();

        Report::create([
            'userID' => $tenant->userID,  // Changed from id
            'itemID' => $item->itemID,  // Already correct
            'roomID' => $room->roomID,  // Already correct
            'report_desc' => 'Broken chair needs repair',
            'report_image' => 'reports/default-report.jpg'
        ]);
    }
}