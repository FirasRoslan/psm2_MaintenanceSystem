<?php

namespace App\Http\Controllers;

use App\Models\HouseTenant;
use App\Models\Report;
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
    
    // Add this method to your LandlordViewController class
    public function maintenanceRequests()
    {
        // Get all reports for properties owned by this landlord
        $user = Auth::user();
        
        // Get reports from houses owned by this landlord
        $reports = Report::whereHas('room.house', function($query) use ($user) {
            $query->where('userID', $user->userID);
        })->with(['room.house', 'item', 'user'])->latest()->get();
        
        return view('landlord.requests.index', compact('reports'));
    }
}