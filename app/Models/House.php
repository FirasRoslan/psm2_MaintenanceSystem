<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $primaryKey = 'houseID';
    public $incrementing = true;

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

    public function tenants()
    {
        return $this->belongsToMany(User::class, 'house_tenant', 'houseID', 'userID')
                    ->where('role', 'tenant')
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }

    // Get only approved tenants
    public function approvedTenants()
    {
        return $this->belongsToMany(User::class, 'house_tenant', 'houseID', 'userID')
                    ->where('role', 'tenant')
                    ->wherePivot('approval_status', true)
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }

    // Get only pending tenants
    public function pendingTenants()
    {
        return $this->belongsToMany(User::class, 'house_tenant', 'houseID', 'userID')
                    ->where('role', 'tenant')
                    ->wherePivot('approval_status', null)
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }

    // Get only rejected tenants
    public function rejectedTenants()
    {
        return $this->belongsToMany(User::class, 'house_tenant', 'houseID', 'userID')
                    ->where('role', 'tenant')
                    ->wherePivot('approval_status', false)
                    ->withPivot('approval_status')
                    ->withTimestamps();
    }
}