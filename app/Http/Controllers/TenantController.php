<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Report;
use App\Models\Room;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    public function dashboard()
    {
        $reports = Auth::user()->reports()->with(['room.house', 'item'])->latest()->get();
        return view('tenant.dashboard', compact('reports'));
    }
    
    public function showHouses()
    {
        $houses = House::with('user')->get();
        return view('tenant.properties.index', compact('houses'));
    }
    
    public function showHouse(House $house)
    {
        // Load the house with its rooms and items
        $house->load('rooms.items', 'user');
        
        return view('tenant.properties.show', compact('house'));
    }
    
    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'roomID' => 'required|exists:rooms,roomID',
            'itemID' => 'required|exists:items,itemID',
            'report_desc' => 'required|string',
            'report_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $imagePath = $request->file('report_image')->store('reports', 'public');
        
        $report = Report::create([
            'userID' => Auth::id(),
            'roomID' => $validated['roomID'],
            'itemID' => $validated['itemID'],
            'report_desc' => $validated['report_desc'],
            'report_image' => $imagePath,
            'report_status' => 'Pending'
        ]);
        
        return back()->with('success', 'Report submitted successfully');
    }
    
    public function getRoomItems(Room $room)
    {
        return response()->json($room->items);
    }
    
    public function showReports()
    {
        $reports = Auth::user()->reports()->with(['room.house', 'item'])->latest()->get();
        return view('tenant.reports.index', compact('reports'));
    }
}