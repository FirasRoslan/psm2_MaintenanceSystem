<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HouseTenant extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'house_tenant';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userID',
        'houseID',
        'approval_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_status' => 'boolean',
    ];

    /**
     * Get the house that the tenant is assigned to.
     */
    public function house()
    {
        return $this->belongsTo(House::class, 'houseID', 'houseID');
    }

    /**
     * Get the tenant user.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}