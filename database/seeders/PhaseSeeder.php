<?php

namespace Database\Seeders;

use App\Models\Phase;
use App\Models\Task;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    public function run(): void
    {
        $task = Task::first();

        Phase::create([
            'taskID' => $task->taskID,  // Already correct
            'arrangement_number' => 1,
            'phase_status' => 'pending',
            'start_timestamp' => now(),
            'end_timestamp' => now()->addDays(3),
            'phase_image' => 'phases/default-phase.jpg'
        ]);
    }
}