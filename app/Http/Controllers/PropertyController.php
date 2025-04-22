<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use App\Models\Item;
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
        $this->authorize('view', $house);
        $house->load('rooms.items');
        return view('landlord.properties.show', compact('house'));
    }

    // Room Management
    public function createRoom(House $house)
    {
        $this->authorize('update', $house);
        return view('landlord.properties.rooms.create', compact('house'));
    }

    public function storeRoom(Request $request, House $house)
    {
        $this->authorize('update', $house);
        
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
        $this->authorize('update', $room->house);
        return view('landlord.properties.items.create', compact('room'));
    }

    public function storeItem(Request $request, Room $room)
    {
        $this->authorize('update', $room->house);

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

        return redirect()->route('landlord.properties.rooms.show', [$room->house->houseID, $room->roomID])
                        ->with('success', 'Item added successfully');
    }

    // Delete methods
    public function deleteHouse(House $house)
    {
        $this->authorize('delete', $house);
        Storage::disk('public')->delete($house->house_image);
        $house->delete();
        return redirect()->route('landlord.properties.index')
                        ->with('success', 'House deleted successfully');
    }

    public function deleteRoom(Room $room)
    {
        $this->authorize('delete', $room->house);
        Storage::disk('public')->delete($room->room_image);
        $room->delete();
        return back()->with('success', 'Room deleted successfully');
    }

    public function deleteItem(Item $item)
    {
        $this->authorize('delete', $item->room->house);
        Storage::disk('public')->delete($item->item_image);
        $item->delete();
        return back()->with('success', 'Item deleted successfully');
    }

    public function getRoomItems(Room $room)
    {
        $this->authorize('view', $room->house);
        return response()->json($room->items);
    }
}