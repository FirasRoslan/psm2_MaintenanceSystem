<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function __construct()
    {
        // We'll handle authorization in each method instead of using middleware here
    }

    // Helper method to check ownership
    private function checkOwnership($model, $modelType)
    {
        if (!$model) return false;
        
        switch ($modelType) {
            case 'house':
                return $model->userID === Auth::id();
            case 'room':
                return $model->house->userID === Auth::id();
            case 'item':
                return $model->room->house->userID === Auth::id();
            default:
                return false;
        }
    }

    // House Management
    public function showHouses()
    {
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        $houses = Auth::user()->houses()->with('rooms')->get();
        return view('landlord.properties.index', compact('houses'));
    }

    public function createHouse()
    {
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
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
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the house belongs to the logged-in landlord
        if (!$this->checkOwnership($house, 'house')) {
            abort(403, 'Unauthorized action.');
        }
        
        $house->load('rooms.items');
        return view('landlord.properties.show', compact('house'));
    }

    // Room Management
    public function createRoom(House $house)
    {
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the house belongs to the logged-in landlord
        if (!$this->checkOwnership($house, 'house')) {
            abort(403, 'Unauthorized action.');
        }
        
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
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the room belongs to the logged-in landlord
        if (!$this->checkOwnership($room, 'room')) {
            abort(403, 'Unauthorized action.');
        }
        
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
    
    // Tenant House Management (changed from Tenant Management)
    // In the showTenants method, update the query to specify the table for userID
    public function showTenants()
    {
        // Get all tenants associated with the landlord's houses
        // This includes tenants with pending, approved, and rejected requests
        $tenants = User::where('role', 'tenant')
            ->whereHas('tenantHouses', function($query) {
                $query->where('houses.userID', Auth::id());
            })
            ->with(['tenantHouses' => function($query) {
                $query->where('houses.userID', Auth::id());
            }])
            ->get();
            
        return view('landlord.properties.tenants.index', compact('tenants'));
    }

    // Update the showTenant method
    public function showTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        // Check if tenant is associated with any of the landlord's houses
        $hasAccess = $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())  // Specify the table name
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only get houses that belong to the current landlord
        $houses = $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())  // Specify the table name
            ->get();
            
        return view('landlord.properties.tenants.show', compact('tenant', 'houses'));
    }

    // Update the editTenant method
    public function editTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        // Check if tenant is associated with any of the landlord's houses
        $hasAccess = $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())  // Specify the table name
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        $houses = Auth::user()->houses()->get();
        
        // For the collection, we need to filter after retrieving
        $assignedHouses = $tenant->tenantHouses
            ->filter(function($house) {
                return $house->userID === Auth::id();
            })
            ->pluck('houseID')
            ->toArray();
        
        return view('landlord.properties.tenants.edit', compact('tenant', 'houses', 'assignedHouses'));
    }

    // Update the updateTenant method
    public function updateTenant(Request $request, User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        // Check if tenant is associated with any of the landlord's houses
        $hasAccess = $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())  // Specify the table name
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$tenant->userID.',userID',
            'phone' => 'required|string|max:20',
            'house_id' => 'required|exists:houses,houseID',
            'approval_status' => 'required|in:active,non active',
            'house_approval_status' => 'required|in:approve,reject,pending',
        ]);
        
        // Check if the house belongs to the landlord
        $house = House::find($validated['house_id']);
        if ($house->userID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        // Update tenant information
        $tenant->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'approval_status' => $validated['approval_status'],
        ]);
    
        // Map the approval status from form to database value
        $houseApprovalStatus = null; // Default is pending
        if ($validated['house_approval_status'] === 'approve') {
            $houseApprovalStatus = true;
        } elseif ($validated['house_approval_status'] === 'reject') {
            $houseApprovalStatus = false;
        }
        
        // Update house assignment with approval status
        $tenant->tenantHouses()->syncWithoutDetaching([
            $validated['house_id'] => ['approval_status' => $houseApprovalStatus]
        ]);
    
        // Redirect to the tenant page
        return redirect()->route('landlord.tenants.show', $tenant->userID)
                        ->with('success', 'Tenant information and house assignment updated successfully');
    }

    // Update the deleteTenant method
    public function deleteTenant(User $tenant)
    {
        if ($tenant->role !== 'tenant') {
            abort(404);
        }
        
        // Check if tenant is associated with any of the landlord's houses
        $hasAccess = $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())  // Specify the table name
            ->exists();
            
        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only detach houses that belong to the current landlord
        $tenant->tenantHouses()
            ->where('houses.userID', Auth::id())
            ->detach();
            
        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Tenant house assignment has been removed successfully');
    }
    
    // Add these methods after your existing tenant-related methods
    
    public function createTenant()
    {
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        $houses = Auth::user()->houses()->get();
        return view('landlord.properties.tenants.create', compact('houses'));
    }

    public function storeTenant(Request $request)
    {
        // Ensure user is authenticated and is a landlord
        if (!Auth::check() || Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'house_id' => 'required|exists:houses,houseID',
        ]);
        
        // Check if the house belongs to the landlord
        $house = House::find($validated['house_id']);
        if ($house->userID !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Create the tenant user
        $tenant = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt('password123'), // Default password, tenant should change it
            'role' => 'tenant',
            'approval_status' => 'active',
        ]);
        
        // Assign tenant to house with pending approval status
        $tenant->tenantHouses()->attach($validated['house_id'], ['approval_status' => null]);
        
        return redirect()->route('landlord.tenants.index')
                        ->with('success', 'Tenant added successfully. Default password is "password123".');
    }
}