<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'itemID';

    protected $fillable = [
        'roomID',
        'item_type',
        'item_name',
        'item_quantity',
        'item_image'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'roomID');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'itemID');
    }
}