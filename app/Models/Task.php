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

    public function phases()
    {
        return $this->hasMany(Phase::class, 'taskID');
    }
    
    /**
     * Get the progress percentage based on completed phases
     */
    public function getProgressPercentageAttribute()
    {
        $totalPhases = $this->phases()->count();
        if ($totalPhases === 0) return 0;
        
        $completedPhases = $this->phases()->where('phase_status', 'completed')->count();
        return round(($completedPhases / $totalPhases) * 100);
    }
    
    /**
     * Get the current active phase
     */
    public function getCurrentPhaseAttribute()
    {
        return $this->phases()
            ->where('phase_status', 'in_progress')
            ->orderBy('arrangement_number')
            ->first();
    }
}