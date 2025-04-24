<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $primaryKey = 'reportID';

    protected $fillable = [
        'userID',
        'itemID',
        'roomID',
        'report_desc',
        'report_image',
        'report_status'
    ];

    protected $casts = [
        'report_status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'reportID');
    }
}