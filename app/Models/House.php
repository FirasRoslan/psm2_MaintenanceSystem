<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $primaryKey = 'houseID';

    protected $fillable = [
        'userID',
        'house_address',
        'house_number_room',
        'house_number_toilet',
        'house_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'houseID');
    }
}