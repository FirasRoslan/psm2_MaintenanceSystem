<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseTenant;
use App\Models\User;
use App\Models\Room;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TenantViewController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get approved houses
        $approvedHouses = $user->approvedHouses()->with('user', 'rooms')->get();
        
        // Get pending houses
        $pendingHouses = $user->pendingHouses()->with('user')->get();
        
        // Get maintenance reports - Fix the ambiguous column name
        $maintenanceReports = \App\Models\Report::whereHas('room.house.tenants', function($query) use ($user) {
            $query->where('users.userID', $user->userID)
                  ->where('house_tenant.approval_status', true);  // Specify the table name
        })->with(['room.house', 'item'])->latest()->get();
        
        return view('tenant.dashboard', compact('approvedHouses', 'pendingHouses', 'maintenanceReports'));
    }
    
    public function findHouses(Request $request)
    {
        // Get search query from request
        $search = $request->get('search');
        
        // Build query for houses
        $query = House::with('user');
        
        // Apply search filter if search term exists
        if ($search) {
            $query->where('house_address', 'LIKE', '%' . $search . '%');
        }
        
        // Get filtered houses
        $houses = $query->get();
        
        return view('tenant.find-houses', compact('houses', 'search'));
    }
    
    public function requestHouse(Request $request)
    {
        $request->validate([
            'houseID' => 'required|exists:houses,houseID',
        ]);
        
        $user = Auth::user();
        $houseID = $request->houseID;
        
        // Check if tenant already has a pending or approved request for this house
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
    
    public function showProperty(House $house)
    {
        // Check if the tenant is assigned to this house
        $user = Auth::user();
        
        // Use the correct query to avoid ambiguous column name
        $isAssigned = $user->tenantHouses()->where('houses.houseID', $house->houseID)->exists();
        
        if (!$isAssigned) {
            abort(403, 'You are not assigned to this property.');
        }
        
        // Load the house with its rooms and items
        $house->load('rooms.items');
        
        return view('tenant.properties.show', compact('house'));
    }
    
    public function getRoomItems(Room $room)
    {
        // Check if the tenant is assigned to the house that contains this room
        $user = Auth::user();
        $isAssigned = $user->tenantHouses()
            ->where('houses.houseID', $room->houseID)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'Unauthorized action.');
        }
        
        return response()->json($room->items);
    }
    
    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'roomID' => 'required|exists:rooms,roomID',
            'itemID' => 'required|exists:items,itemID',
            'report_desc' => 'required|string',
            'report_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Get the room and check if tenant is assigned to the house
        $room = Room::findOrFail($validated['roomID']);
        $user = Auth::user();
        
        $isAssigned = $user->tenantHouses()
            ->where('houses.houseID', $room->houseID)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'Unauthorized action.');
        }
        
        // Store the image
        $imagePath = $request->file('report_image')->store('reports', 'public');
        
        // Create the report
        $report = Report::create([
            'userID' => $user->userID,
            'roomID' => $validated['roomID'],
            'itemID' => $validated['itemID'],
            'report_desc' => $validated['report_desc'],
            'report_image' => $imagePath,
            'report_status' => 'Pending'
        ]);
        
        return redirect()->back()->with('success', 'Maintenance report submitted successfully. The landlord will review it soon.');
    }
    
    // Add this method to your TenantViewController class
    public function reports()
    {
        $reports = Report::where('userID', auth()->id())
                    ->with(['room.house', 'item'])
                    ->latest()
                    ->get();
        
        return view('tenant.reports.index', compact('reports'));
    }
    
    public function viewAssignedHouses()
    {
        $user = Auth::user();
        
        // Get all houses assigned to this tenant (both pending and approved)
        $houses = $user->tenantHouses()->with('user')->get();
        
        return view('tenant.assigned-houses', compact('houses'));
    }
}