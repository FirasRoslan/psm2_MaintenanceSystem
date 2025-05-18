@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $house->house_address }}</h4>
            <p class="text-muted mb-0">Property Details</p>
        </div>
        <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to My Properties
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
            
            <!-- Maintenance Report Button -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Maintenance Report</h5>
                    <p class="text-muted">Report any issues with the property</p>
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <i class="fas fa-tools me-2"></i>Submit Maintenance Report
                    </button>
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

<!-- Maintenance Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Submit Maintenance Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tenant.reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                    @csrf
                    <div class="mb-3">
                        <label for="roomID" class="form-label">Select Room</label>
                        <select class="form-select" id="roomID" name="roomID" required>
                            <option value="">Select a room</option>
                            @foreach($house->rooms as $room)
                                <option value="{{ $room->roomID }}">{{ $room->room_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="itemID" class="form-label">Select Item</label>
                        <select class="form-select" id="itemID" name="itemID" required disabled>
                            <option value="">Select a room first</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="report_desc" class="form-label">Problem Description</label>
                        <textarea class="form-control" id="report_desc" name="report_desc" rows="4" required placeholder="Describe the issue in detail..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="report_image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="report_image" name="report_image" accept="image/*" required>
                        <div class="form-text">Upload a clear image of the issue (JPEG, PNG, JPG only, max 2MB)</div>
                    </div>
                    
                    <div id="imagePreview" class="mt-3 d-none">
                        <h6>Image Preview</h6>
                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitReport">Submit Report</button>
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
                fetch(`/tenant/properties/rooms/${roomId}/items`)
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
        
        // Handle room selection for maintenance report
        const roomSelect = document.getElementById('roomID');
        const itemSelect = document.getElementById('itemID');
        
        roomSelect.addEventListener('change', function() {
            const roomId = this.value;
            
            if (roomId) {
                // Enable item select
                itemSelect.disabled = false;
                itemSelect.innerHTML = '<option value="">Loading items...</option>';
                
                // Fetch items for the selected room
                fetch(`/tenant/properties/rooms/${roomId}/items`)
                    .then(response => response.json())
                    .then(items => {
                        let options = '<option value="">Select an item</option>';
                        
                        if (items.length > 0) {
                            items.forEach(item => {
                                options += `<option value="${item.itemID}">${item.item_name} (${item.item_type})</option>`;
                            });
                        } else {
                            options = '<option value="">No items available</option>';
                        }
                        
                        itemSelect.innerHTML = options;
                    })
                    .catch(error => {
                        itemSelect.innerHTML = '<option value="">Error loading items</option>';
                        console.error('Error fetching items:', error);
                    });
            } else {
                // Disable item select if no room is selected
                itemSelect.disabled = true;
                itemSelect.innerHTML = '<option value="">Select a room first</option>';
            }
        });
        
        // Image preview
        const imageInput = document.getElementById('report_image');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.classList.remove('d-none');
                    imagePreview.querySelector('img').src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.classList.add('d-none');
            }
        });
        
        // Submit report form
        document.getElementById('submitReport').addEventListener('click', function() {
            document.getElementById('reportForm').submit();
        });
    });
</script>
@endpush

@endsection