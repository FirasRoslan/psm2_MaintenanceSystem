<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'taskID';

    protected $fillable = [
        'reportID',
        'userID',
        'task_type',
        'task_status',
        'task_notes',
        'completed_at'
    ];

    protected $dates = [
        'completed_at'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reportID');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}