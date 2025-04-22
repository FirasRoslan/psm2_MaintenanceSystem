@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Property Details -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <img src="{{ asset('storage/' . $house->house_image) }}" 
                     class="card-img-top" 
                     alt="{{ $house->house_address }}"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h4>{{ $house->house_address }}</h4>
                    <div class="mb-3">
                        <span class="badge bg-info me-2">{{ $house->house_number_room }} Rooms</span>
                        <span class="badge bg-secondary">{{ $house->house_number_toilet }} Toilets</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms List -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rooms</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="fas fa-plus me-2"></i>Add Room
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($house->rooms as $room)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $room->room_image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $room->room_type }}"
                                         style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $room->room_type }}</h5>
                                        <p class="text-muted">{{ $room->items->count() }} items</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#addItemModal" 
                                                    data-room-id="{{ $room->roomID }}">
                                                <i class="fas fa-plus me-2"></i>Add Item
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-outline-info btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewItemsModal" 
                                                    data-room-id="{{ $room->roomID }}">
                                                <i class="fas fa-eye me-2"></i>View Items
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-door-closed fa-3x text-muted mb-3"></i>
                                <h5>No Rooms Added Yet</h5>
                                <p class="text-muted">Start by adding rooms to your property</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('landlord.properties.rooms.store', $house->houseID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="room_type" class="form-label">Room Type</label>
                        <select class="form-select @error('room_type') is-invalid @enderror" 
                                id="room_type" 
                                name="room_type" 
                                required>
                            <option value="">Select Room Type</option>
                            <option value="Bedroom">Bedroom</option>
                            <option value="Living Room">Living Room</option>
                            <option value="Kitchen">Kitchen</option>
                            <option value="Bathroom">Bathroom</option>
                            <option value="Dining Room">Dining Room</option>
                        </select>
                        @error('room_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="room_image" class="form-label">Room Image</label>
                        <input type="file" 
                               class="form-control @error('room_image') is-invalid @enderror" 
                               id="room_image" 
                               name="room_image"
                               accept="image/jpeg,image/png,image/jpg" 
                               required>
                        @error('room_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addItemForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_type" class="form-label">Item Type</label>
                        <input type="text" 
                               class="form-control @error('item_type') is-invalid @enderror" 
                               id="item_type" 
                               name="item_type" 
                               required>
                        @error('item_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" 
                               class="form-control @error('item_name') is-invalid @enderror" 
                               id="item_name" 
                               name="item_name" 
                               required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="item_quantity" class="form-label">Quantity</label>
                        <input type="number" 
                               class="form-control @error('item_quantity') is-invalid @enderror" 
                               id="item_quantity" 
                               name="item_quantity" 
                               min="1" 
                               required>
                        @error('item_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="item_image" class="form-label">Item Image</label>
                        <input type="file" 
                               class="form-control @error('item_image') is-invalid @enderror" 
                               id="item_image" 
                               name="item_image"
                               accept="image/jpeg,image/png,image/jpg" 
                               required>
                        @error('item_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Items Modal -->
<div class="modal fade" id="viewItemsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="itemsList" class="row">
                    <!-- Items will be loaded here via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle Add Item Modal
    const addItemModal = document.getElementById('addItemModal');
    addItemModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roomId = button.getAttribute('data-room-id');
        const form = this.querySelector('#addItemForm');
        form.action = `/rooms/${roomId}/items`;
    });

    // Handle View Items Modal
    const viewItemsModal = document.getElementById('viewItemsModal');
    viewItemsModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roomId = button.getAttribute('data-room-id');
        const itemsList = this.querySelector('#itemsList');
        
        // Fetch items for the room
        fetch(`/rooms/${roomId}/items`)
            .then(response => response.json())
            .then(items => {
                itemsList.innerHTML = items.map(item => `
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="/storage/${item.item_image}" class="card-img-top" alt="${item.item_name}" style="height: 120px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">${item.item_name}</h6>
                                <p class="card-text">
                                    <small class="text-muted">Type: ${item.item_type}</small><br>
                                    <small class="text-muted">Quantity: ${item.item_quantity}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                `).join('');
            });
    });
</script>
@endpush