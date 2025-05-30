@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Modern Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tenant.assigned-houses') }}" class="text-white text-decoration-none opacity-75">
                                    <i class="fas fa-home me-1"></i>My Properties
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                Property Details
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Title Section -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-container me-3">
                            <i class="fas fa-building text-white fa-2x"></i>
                        </div>
                        <div>
                            <h1 class="text-white fw-bold mb-1 display-6">{{ $house->house_address }}</h1>
                            <p class="text-white opacity-90 mb-0 fs-5">Property Details & Room Management</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to My Properties
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg text-success"></i>
            </div>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Property Information Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $house->house_image) }}" class="card-img-top rounded-top-4" alt="Property Image" style="height: 250px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill shadow">
                            <i class="fas fa-check-circle me-1"></i>Approved Property
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Property Information</h5>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-2 me-3">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Address</small>
                                <span class="fw-medium">{{ $house->house_address }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-2 mx-auto mb-2">
                                    <i class="fas fa-bed text-primary"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $house->house_number_room }}</h6>
                                <small class="text-muted">Rooms</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="icon-box bg-info bg-opacity-10 p-2 rounded-2 mx-auto mb-2">
                                    <i class="fas fa-bath text-info"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $house->house_number_toilet }}</h6>
                                <small class="text-muted">Bathrooms</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-secondary bg-opacity-10 p-2 rounded-2 me-3">
                            <i class="fas fa-user text-secondary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Landlord</small>
                            <span class="fw-medium">{{ $house->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Maintenance Report Card -->
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="icon-box bg-warning bg-opacity-10 p-3 rounded-3 mx-auto mb-3">
                            <i class="fas fa-tools text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Maintenance Report</h5>
                        <p class="text-muted mb-4">Report any issues with the property</p>
                        <button class="btn btn-warning w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-tools me-2"></i>Submit Maintenance Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Property Rooms</h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            {{ $house->rooms->count() }} Rooms Available
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($house->rooms->count() > 0)
                        <div class="row">
                            @foreach($house->rooms as $room)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $room->room_image) }}" class="card-img-top rounded-top-3" alt="Room Image" style="height: 200px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-3">
                                                <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill">
                                                    {{ $room->items->count() }} items
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-2 me-3">
                                                    <i class="fas fa-door-open text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1">{{ $room->room_type }}</h6>
                                                    <small class="text-muted">Room Details</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-outline-primary btn-sm w-100 rounded-pill view-items" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#itemsModal" 
                                                    data-room-id="{{ $room->roomID }}" 
                                                    data-room-name="{{ $room->room_type }}">
                                                <i class="fas fa-list me-2"></i>View Items ({{ $room->items->count() }})
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-box bg-light p-4 rounded-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-door-closed fa-2x text-muted"></i>
                            </div>
                            <h6 class="fw-bold text-muted mb-2">No Rooms Added Yet</h6>
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
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold" id="itemsModalLabel">Room Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="items-container">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-2">Loading room items...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold" id="reportModalLabel">Submit Maintenance Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tenant.reports.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="houseID" value="{{ $house->houseID }}">
                    
                    <div class="mb-4">
                        <label for="roomID" class="form-label fw-medium">Select Room</label>
                        <select class="form-select rounded-3" id="roomID" name="roomID" required>
                            <option value="">Choose a room...</option>
                            @foreach($house->rooms as $room)
                                <option value="{{ $room->roomID }}">{{ $room->room_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="report_description" class="form-label fw-medium">Issue Description</label>
                        <textarea class="form-control rounded-3" id="report_description" name="report_description" rows="4" placeholder="Describe the maintenance issue in detail..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning rounded-pill">
                        <i class="fas fa-paper-plane me-2"></i>Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Load room items when modal is opened
document.addEventListener('DOMContentLoaded', function() {
    const viewItemsButtons = document.querySelectorAll('.view-items');
    
    viewItemsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-room-id');
            const roomName = this.getAttribute('data-room-name');
            
            document.getElementById('itemsModalLabel').textContent = roomName + ' Items';
            
            // Load items via AJAX
            fetch(`/tenant/rooms/${roomId}/items`)
                .then(response => response.json())
                .then(data => {
                    let itemsHtml = '';
                    if (data.items && data.items.length > 0) {
                        itemsHtml = '<div class="row">';
                        data.items.forEach(item => {
                            itemsHtml += `
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-2 me-3">
                                                    <i class="fas fa-cube text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-1">${item.item_name}</h6>
                                                    <small class="text-muted">${item.item_description || 'No description'}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        itemsHtml += '</div>';
                    } else {
                        itemsHtml = `
                            <div class="text-center py-4">
                                <div class="icon-box bg-light p-3 rounded-3 mx-auto mb-3">
                                    <i class="fas fa-box-open fa-2x text-muted"></i>
                                </div>
                                <h6 class="text-muted">No Items Found</h6>
                                <p class="text-muted mb-0">This room doesn't have any items yet.</p>
                            </div>
                        `;
                    }
                    
                    document.getElementById('items-container').innerHTML = itemsHtml;
                })
                .catch(error => {
                    console.error('Error loading items:', error);
                    document.getElementById('items-container').innerHTML = `
                        <div class="text-center py-4">
                            <div class="icon-box bg-danger bg-opacity-10 p-3 rounded-3 mx-auto mb-3">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                            </div>
                            <h6 class="text-danger">Error Loading Items</h6>
                            <p class="text-muted mb-0">Unable to load room items. Please try again.</p>
                        </div>
                    `;
                });
        });
    });
});
</script>

@push('styles')
<style>
    /* Modern Header Styles */
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: rgba(255, 255, 255, 0.7);
        font-weight: bold;
    }
    
    .breadcrumb-item a:hover {
        opacity: 1 !important;
        text-decoration: underline !important;
    }
    
    .icon-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }
    
    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 1.5rem;
        }
        
        .icon-container {
            width: 50px;
            height: 50px;
        }
        
        .icon-container i {
            font-size: 1.5rem !important;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .btn-light {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem;
        }
    }
</style>
@endpush

.hover-lift {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}
</style>
@endsection