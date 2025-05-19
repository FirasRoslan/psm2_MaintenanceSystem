<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorLandlord extends Model
{
    use HasFactory;
    
    protected $table = 'contractor_landlord';
    
    protected $fillable = [
        'contractorID',
        'landlordID',
        'maintenance_scope',
        'specialization',
        'approval_status'
    ];
    
    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractorID');
    }
    
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlordID');
    }
}