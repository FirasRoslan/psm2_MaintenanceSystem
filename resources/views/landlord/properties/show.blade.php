@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>{{ $house->house_address }}</h4>
        <div>
            <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <a href="{{ route('landlord.properties.rooms.create', $house->houseID) }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Room
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('storage/' . $house->house_image) }}" 
                     class="card-img-top" 
                     alt="{{ $house->house_address }}"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-info me-2">{{ $house->house_number_room }} Rooms</span>
                        <span class="badge bg-secondary">{{ $house->house_number_toilet }} Toilets</span>
                    </div>
                    <div class="d-grid gap-2">
                        <form action="{{ route('landlord.properties.delete', $house->houseID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Property
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Rooms ({{ $house->rooms->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($house->rooms->count() > 0)
                        <div class="row">
                            @foreach($house->rooms as $room)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $room->room_image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $room->room_type }}"
                                             style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $room->room_type }}</h5>
                                            <p class="card-text text-muted">
                                                <small>{{ $room->items->count() }} items</small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent d-flex justify-content-between">
                                            <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-plus me-1"></i> Add Item
                                            </a>
                                            <form action="{{ route('landlord.properties.rooms.delete', $room->roomID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-door-open fa-3x text-muted"></i>
                            </div>
                            <h5>No rooms added yet</h5>
                            <p class="text-muted">Add rooms to your property</p>
                            <a href="{{ route('landlord.properties.rooms.create', $house->houseID) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Room
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Items Section -->
    @if($house->rooms->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">All Items</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="roomsAccordion">
                    @foreach($house->rooms as $index => $room)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#room{{ $room->roomID }}">
                                    {{ $room->room_type }} ({{ $room->items->count() }} items)
                                </button>
                            </h2>
                            <div id="room{{ $room->roomID }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#roomsAccordion">
                                <div class="accordion-body">
                                    @if($room->items->count() > 0)
                                        <div class="row">
                                            @foreach($room->items as $item)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card h-100">
                                                        <img src="{{ asset('storage/' . $item->item_image) }}" 
                                                             class="card-img-top" 
                                                             alt="{{ $item->item_name }}"
                                                             style="height: 120px; object-fit: cover;">
                                                        <div class="card-body">
                                                            <h6 class="card-title">{{ $item->item_name }}</h6>
                                                            <p class="card-text">
                                                                <small class="text-muted">Type: {{ $item->item_type }}</small><br>
                                                                <small class="text-muted">Quantity: {{ $item->item_quantity }}</small>
                                                            </p>
                                                        </div>
                                                        <div class="card-footer bg-transparent text-end">
                                                            <form action="{{ route('landlord.properties.items.delete', $item->itemID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-3">
                                            <p class="text-muted">No items in this room</p>
                                            <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus me-1"></i> Add Item
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection