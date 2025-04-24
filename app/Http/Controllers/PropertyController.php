<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use App\Models\Item;
use App\Models\User;  // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    // House Management
    public function showHouses()
    {
        $houses = Auth::user()->houses()->with('rooms')->get();
        return view('landlord.properties.index', compact('houses'));
    }

    public function createHouse()
    {
        return view('landlord.properties.create');
    }

    public function storeHouse(Request $request)
    {
        $validated = $request->validate([
            'house_address' => 'required|string|max:255',
            'house_number_room' => 'required|integer|min:1',
            'house_number_toilet' => 'required|integer|min:0',
            'house_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('house_image')->store('houses', 'public');
        
        $house = Auth::user()->houses()->create([
            'house_address' => $validated['house_address'],
            'house_number_room' => $validated['house_number_room'],
            'house_number_toilet' => $validated['house_number_toilet'],
            'house_image' => $imagePath
        ]);

        return redirect()->route('landlord.properties.show', $house->houseID)
                        ->with('success', 'House added successfully');
    }

    public function showHouse(House $house)
    {
        $house->load('rooms.items');
        return view('landlord.properties.show', compact('house'));
    }

    // Room Management
    public function createRoom(House $house)
    {
        return view('landlord.properties.rooms.create', compact('house'));
    }

    public function storeRoom(Request $request, House $house)
    {
        $validated = $request->validate([
            'room_type' => 'required|string|max:255',
            'room_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('room_image')->store('rooms', 'public');

        $room = $house->rooms()->create([
            'room_type' => $validated['room_type'],
            'room_image' => $imagePath
        ]);

        return redirect()->route('landlord.properties.show', $house->houseID)
                        ->with('success', 'Room added successfully');
    }

    // Item Management
    public function createItem(Room $room)
    {
        return view('landlord.properties.items.create', compact('room'));
    }

    public function storeItem(Request $request, Room $room)
    {
        $validated = $request->validate([
            'item_type' => 'required|string|max:255',
            'item_name' => 'required|string|max:255',
            'item_quantity' => 'required|integer|min:1',
            'item_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('item_image')->store('items', 'public');

        $item = $room->items()->create([
            'item_type' => $validated['item_type'],
            'item_name' => $validated['item_name'],
            'item_quantity' => $validated['item_quantity'],
            'item_image' => $imagePath
        ]);

        return redirect()->route('landlord.properties.show', $room->house->houseID)
                        ->with('success', 'Item added successfully');
    }

    // Delete methods
    public function deleteHouse(House $house)
    {
        Storage::disk('public')->delete($house->house_image);
        $house->delete();
        return redirect()->route('landlord.properties.index')
                        ->with('success', 'House deleted successfully');
    }

    public function deleteRoom(Room $room)
    {
        Storage::disk('public')->delete($room->room_image);
        $room->delete();
        return back()->with('success', 'Room deleted successfully');
    }

    public function deleteItem(Item $item)
    {
        Storage::disk('public')->delete($item->item_image);
        $item->delete();
        return back()->with('success', 'Item deleted successfully');
    }

    public function getRoomItems(Room $room)
    {
        return response()->json($room->items);
    }

    // Add these methods to your existing PropertyController class
    
    // Tenant Management
    public function showTenants()
    {
        $tenants = User::where('role', 'tenant')->get();
        return view('landlord.properties.tenants.index', compact('tenants'));
    }

    public function createTenant()
    {
        $houses = Auth::user()->houses()->get();
        return view('landlord.properties.tenants.create', compact('houses'));
    }

    public function storeTenant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'house_id' => 'required|exists:houses,houseID',
        ]);
    
        // Create user with tenant role
        $tenant = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt('password123'), // Default password
            'role' => 'tenant',
        ]);
    
        // Assign tenant to house
        $house = House::find($validated['house_id']);
        $house->tenants()->attach($tenant->id);
    
        return redirect()->route('landlord.tenants.index')
                        ->with('success', 'Tenant added successfully');
    }

    public function showTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        $houses = $tenant->tenantHouses;
        return view('landlord.properties.tenants.show', compact('tenant', 'houses'));
    }

    public function editTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        $houses = Auth::user()->houses()->get();
        $assignedHouses = $tenant->tenantHouses->pluck('houseID')->toArray();
        
        return view('landlord.properties.tenants.edit', compact('tenant', 'houses', 'assignedHouses'));
    }

    public function updateTenant(Request $request, User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$tenant->id,
            'phone' => 'required|string|max:20',
            'house_id' => 'required|exists:houses,houseID',
        ]);
    
        $tenant->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);
    
        // Update house assignment
        $tenant->tenantHouses()->sync([$validated['house_id']]);
    
        return redirect()->route('landlord.tenants.index')
                        ->with('success', 'Tenant updated successfully');
    }

    public function deleteTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        // Detach from all houses
        $tenant->tenantHouses()->detach();
        
        // Delete the user
        $tenant->delete();
        
        return redirect()->route('landlord.tenants.index')
                        ->with('success', 'Tenant deleted successfully');
    }
}