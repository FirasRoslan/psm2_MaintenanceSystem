<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $contractor = User::where('role', 'contractor')->first();
        $report = Report::first();

        Task::create([
            'reportID' => $report->reportID,
            'userID' => $contractor->id,
            'task_status' => 'pending',
            'task_type' => 'repair'
        ]);
    }
}