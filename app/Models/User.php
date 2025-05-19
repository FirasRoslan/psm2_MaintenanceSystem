<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'userID';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'approval',
        'approval_status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'approval' => 'boolean'
    ];

    public function houses()
    {
        return $this->hasMany(House::class, 'userID');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'userID');
    }

    // Add these methods to your User model

    // For contractors
    public function landlords()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'contractorID', 'landlordID')
                    ->where('role', 'landlord')
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    public function approvedLandlords()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'contractorID', 'landlordID')
                    ->where('role', 'landlord')
                    ->wherePivot('approval_status', true)
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    public function pendingLandlordRequests()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'contractorID', 'landlordID')
                    ->where('role', 'landlord')
                    ->wherePivot('approval_status', null)
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    // For landlords
    public function contractors()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'landlordID', 'contractorID')
                    ->where('role', 'contractor')
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    public function approvedContractors()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'landlordID', 'contractorID')
                    ->where('role', 'contractor')
                    ->wherePivot('approval_status', true)
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    public function pendingContractorRequests()
    {
        return $this->belongsToMany(User::class, 'contractor_landlord', 'landlordID', 'contractorID')
                    ->where('role', 'contractor')
                    ->wherePivot('approval_status', null)
                    ->withPivot('maintenance_scope', 'specialization', 'approval_status')
                    ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'userID');
    }

    public function isLandlord()
    {
        return $this->role === 'landlord';
    }

    public function isTenant()
    {
        return $this->role === 'tenant';
    }

    public function isContractor()
    {
        return $this->role === 'contractor';
    }

    public function tenantHouses()
    {
        return $this->belongsToMany(House::class, 'house_tenant', 'userID', 'houseID')
                ->withPivot('approval_status')
                ->withTimestamps();
    }

    // Get only approved houses for tenant
    public function approvedHouses()
    {
        return $this->belongsToMany(House::class, 'house_tenant', 'userID', 'houseID')
                ->wherePivot('approval_status', true)
                ->withPivot('approval_status')
                ->withTimestamps();
    }

    // Get only pending houses for tenant
    public function pendingHouses()
    {
        return $this->belongsToMany(House::class, 'house_tenant', 'userID', 'houseID')
                ->wherePivot('approval_status', null)
                ->withPivot('approval_status')
                ->withTimestamps();
    }

    // Get only rejected houses for tenant
    public function rejectedHouses()
    {
        return $this->belongsToMany(House::class, 'house_tenant', 'userID', 'houseID')
                ->wherePivot('approval_status', false)
                ->withPivot('approval_status')
                ->withTimestamps();
    }
}
