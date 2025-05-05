<?php

namespace App\Http\Controllers;

use App\Models\HouseTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandlordViewController extends Controller
{
    public function dashboard()
    {
        // Get count of pending tenant requests
        $pendingRequestsCount = HouseTenant::whereHas('house', function($query) {
            $query->where('userID', Auth::id());
        })
        ->whereNull('approval_status')
        ->count();
        
        return view('landlord.dashboard', compact('pendingRequestsCount'));
    }
}