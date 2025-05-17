<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseTenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantViewController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get tenant's house assignments with their status
        $pendingHouses = $user->pendingHouses()->with('user')->get();
        $approvedHouses = $user->approvedHouses()->with('user')->get();
        $rejectedHouses = $user->rejectedHouses()->with('user')->get();
        
        return view('tenant.dashboard', compact('pendingHouses', 'approvedHouses', 'rejectedHouses'));
    }
    
    public function findHouses()
    {
        // Get all houses that are available
        $houses = House::with('user')->get();
        
        return view('tenant.find-houses', compact('houses'));
    }
    
    public function requestHouse(Request $request)
    {
        $request->validate([
            'houseID' => 'required|exists:houses,houseID',
        ]);
        
        $user = Auth::user();
        $houseID = $request->houseID;
        
        // Check if tenant already has a pending or approved request for this house
        // Specify the table name to avoid ambiguity
        $existingRequest = HouseTenant::where('userID', $user->userID)
            ->where('houseID', $houseID)
            ->first();
            
        if ($existingRequest) {
            return back()->with('error', 'You have already requested this property.');
        }
        
        // Create a new house-tenant relationship with null approval_status (pending)
        $houseTenant = new HouseTenant();
        $houseTenant->userID = $user->userID;
        $houseTenant->houseID = $houseID;
        $houseTenant->approval_status = null; // Pending approval
        $houseTenant->save();
        
        return redirect()->route('tenant.dashboard')
            ->with('success', 'Your request has been submitted and is pending approval from the landlord.');
    }
    
    public function viewAssignedHouses()
    {
        $user = Auth::user();
        
        // Get all houses assigned to the tenant with their approval status
        $houses = $user->tenantHouses()->with('user')->get();
        
        return view('tenant.assigned-houses', compact('houses'));
    }
    
    // We need to add or update a method to show property details for tenants
    public function showProperty(House $house)
    {
        // Check if the tenant is assigned to this house
        $user = Auth::user();
        
        // This is the correct version - use this one and remove the problematic line
        $isAssigned = $user->tenantHouses()->where('houses.houseID', $house->houseID)->exists();
        
        if (!$isAssigned) {
            abort(403, 'You are not assigned to this property.');
        }
        
        // Load the house with its rooms and items
        $house->load('rooms.items');
        
        return view('tenant.properties.show', compact('house'));
    }
}