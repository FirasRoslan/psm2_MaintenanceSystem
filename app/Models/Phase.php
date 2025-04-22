<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $primaryKey = 'phaseID';

    protected $fillable = [
        'taskID',
        'arrangement_number',
        'phase_status',
        'start_timestamp',
        'end_timestamp',
        'phase_image'
    ];

    protected $casts = [
        'start_timestamp' => 'datetime',
        'end_timestamp' => 'datetime',
        'phase_status' => 'string'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'taskID');
    }
}