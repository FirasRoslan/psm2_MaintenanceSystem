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
        'task_status',
        'task_type'
    ];

    protected $casts = [
        'task_status' => 'string'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reportID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function phases()
    {
        return $this->hasMany(Phase::class, 'taskID');
    }
}