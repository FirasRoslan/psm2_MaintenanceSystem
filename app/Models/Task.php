<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'taskID';
    
    public function getRouteKeyName()
    {
        return 'taskID';
    }

    protected $fillable = [
        'reportID',
        'userID',
        'task_type',
        'task_status',
        'task_notes',
        'completion_image',
        'completion_notes',
        'completed_at',
        'submitted_at'
    ];

    // Replace the old $dates property with $casts
    protected $casts = [
        'completed_at' => 'datetime',
        'submitted_at' => 'datetime'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reportID');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function phases()
    {
        return $this->hasMany(Phase::class, 'taskID');
    }
    
    public function getProgressPercentageAttribute()
    {
        $totalPhases = $this->phases()->count();
        if ($totalPhases === 0) return 0;
        
        $completedPhases = $this->phases()->where('phase_status', 'completed')->count();
        return round(($completedPhases / $totalPhases) * 100);
    }
    
    public function getCurrentPhaseAttribute()
    {
        return $this->phases()
            ->where('phase_status', 'in_progress')
            ->orderBy('arrangement_number')
            ->first();
    }

    public function setTaskStatusAttribute($value)
    {
        $allowedStatuses = ['pending', 'in_progress', 'awaiting_approval', 'completed'];
        
        if (!in_array($value, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid task status: {$value}");
        }
        
        $this->attributes['task_status'] = $value;
    }
}