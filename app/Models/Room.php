<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'roomID';

    protected $fillable = [
        'houseID',
        'room_image',
        'room_type'
    ];

    public function house()
    {
        return $this->belongsTo(House::class, 'houseID');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'roomID');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'roomID');
    }
}