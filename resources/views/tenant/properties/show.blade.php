@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $house->house_address }}</h4>
            <p class="text-muted mb-0">Property Details</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="{{ asset('storage/' . $house->house_image) }}" class="card-img-top" alt="Property Image">
                <div class="card-body">
                    <h5 class="card-title">Property Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Address</span>
                            <span class="text-muted">{{ $house->house_address }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Number of Rooms</span>
                            <span class="badge bg-primary rounded-pill">{{ $house->house_number_room }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Number of Toilets</span>
                            <span class="badge bg-primary rounded-pill">{{ $house->house_number_toilet }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Landlord</span>
                            <span class="text-muted">{{ $house->user->name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Rooms</h5>
                </div>
                <div class="card-body">
                    @if($house->rooms->count() > 0)
                        <div class="row">
                            @foreach($house->rooms as $room)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $room->room_image) }}" class="card-img-top" alt="Room Image" style="height: 180px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $room->room_type }}</h6>
                                            <p class="card-text text-muted">{{ $room->items->count() }} items</p>
                                            <button class="btn btn-sm btn-outline-primary view-items" data-bs-toggle="modal" data-bs-target="#itemsModal" data-room-id="{{ $room->roomID }}" data-room-name="{{ $room->room_type }}">
                                                <i class="fas fa-list me-1"></i> View Items
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-door-closed fa-3x text-muted mb-3"></i>
                            <h6>No Rooms Added Yet</h6>
                            <p class="text-muted">The landlord hasn't added any rooms to this property yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Items Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemsModalLabel">Room Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="items-container">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading items...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle view items button click
        const viewItemsBtns = document.querySelectorAll('.view-items');
        viewItemsBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const roomId = this.getAttribute('data-room-id');
                const roomName = this.getAttribute('data-room-name');
                
                // Update modal title
                document.getElementById('itemsModalLabel').textContent = roomName + ' - Items';
                
                // Show loading spinner
                document.getElementById('items-container').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading items...</p>
                    </div>
                `;
                
                // Fetch items for the room
                fetch(`/landlord/properties/rooms/${roomId}/items`)
                    .then(response => response.json())
                    .then(items => {
                        let html = '';
                        
                        if (items.length === 0) {
                            html = `
                                <div class="text-center py-4">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h6>No Items Found</h6>
                                    <p class="text-muted">There are no items in this room yet.</p>
                                </div>
                            `;
                        } else {
                            html = '<div class="row">';
                            items.forEach(item => {
                                html += `
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <img src="/storage/${item.item_image}" class="card-img-top" alt="${item.item_name}" style="height: 150px; object-fit: cover;">
                                            <div class="card-body">
                                                <h6 class="card-title">${item.item_name}</h6>
                                                <p class="card-text text-muted">Type: ${item.item_type}</p>
                                                <p class="card-text">Quantity: ${item.item_quantity}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            html += '</div>';
                        }
                        
                        document.getElementById('items-container').innerHTML = html;
                    })
                    .catch(error => {
                        document.getElementById('items-container').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Failed to load items. Please try again.
                            </div>
                        `;
                        console.error('Error fetching items:', error);
                    });
            });
        });
    });
</script>
@endpush
@endsection