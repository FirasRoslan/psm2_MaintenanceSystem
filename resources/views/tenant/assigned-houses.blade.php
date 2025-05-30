@extends('ui.layout')

@section('title', 'My Assigned Properties')

@section('content')
<div class="container-fluid py-4">
    <!-- Modern Card-Based Header -->
    <div class="header-card mb-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-gradient-primary border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-2">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('tenant.dashboard') }}" class="text-white text-decoration-none opacity-75">
                                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">My Properties</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('tenant.dashboard') }}" class="btn btn-light btn-sm rounded-pill px-3 back-btn">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
                
                <div class="d-flex align-items-center mt-3">
                    <div class="icon-container me-3">
                        <i class="fas fa-home fa-2x text-white"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-white mb-1 gradient-text">My Properties</h2>
                        <p class="text-white opacity-75 mb-0 fs-6">Manage your assigned rental properties</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($houses->count() > 0)
        <!-- Properties Grid -->
        <div class="row">
            @foreach($houses as $house)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden hover-lift">
                        <!-- Status Header -->
                        <div class="card-header border-0 p-0">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $house->house_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $house->house_address }}" 
                                     style="height: 220px; object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge 
                                        @if($house->pivot->approval_status === null) bg-warning
                                        @elseif($house->pivot->approval_status === true) bg-success
                                        @else bg-danger
                                        @endif bg-opacity-90 text-white px-3 py-2 rounded-pill shadow">
                                        <i class="fas 
                                            @if($house->pivot->approval_status === null) fa-clock
                                            @elseif($house->pivot->approval_status === true) fa-check-circle
                                            @else fa-times-circle
                                            @endif me-1"></i>
                                        @if($house->pivot->approval_status === null)
                                            Pending Approval
                                        @elseif($house->pivot->approval_status === true)
                                            Approved
                                        @else
                                            Rejected
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">{{ $house->house_address }}</h5>
                            
                            <!-- Property Details -->
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-2 me-2">
                                            <i class="fas fa-bed text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Rooms</small>
                                            <span class="fw-bold">{{ $house->house_number_room }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-info bg-opacity-10 p-2 rounded-2 me-2">
                                            <i class="fas fa-bath text-info"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Bathrooms</small>
                                            <span class="fw-bold">{{ $house->house_number_toilet }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Landlord Info -->
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
                        
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            @if($house->pivot->approval_status === true)
                                <a href="{{ route('tenant.properties.show', $house->houseID) }}" 
                                   class="btn btn-primary w-100 rounded-pill">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                            @elseif($house->pivot->approval_status === null)
                                <button class="btn btn-outline-warning w-100 rounded-pill" disabled>
                                    <i class="fas fa-clock me-2"></i>Awaiting Approval
                                </button>
                            @else
                                <button class="btn btn-outline-danger w-100 rounded-pill" disabled>
                                    <i class="fas fa-times me-2"></i>Request Rejected
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center py-5">
                        <div class="icon-box bg-light p-4 rounded-3 d-inline-flex mb-4">
                            <i class="fas fa-home fa-3x text-muted"></i>
                        </div>
                        <h4 class="fw-bold mb-3">No Properties Yet</h4>
                        <p class="text-muted mb-4">You don't have any property assignments yet. Start by finding and requesting a property.</p>
                        <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-search me-2"></i>Find Properties
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
/* Header Card Styling */
.header-card .bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: rgba(255, 255, 255, 0.6);
}

.icon-container {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.gradient-text {
    background: linear-gradient(45deg, #ffffff, #e3f2fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.back-btn {
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Existing Styles */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-card .card-header {
        padding: 1.5rem !important;
    }
    
    .header-card .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .back-btn {
        margin-top: 1rem;
        align-self: flex-end;
    }
    
    .breadcrumb {
        font-size: 0.875rem;
    }
    
    .gradient-text {
        font-size: 1.5rem !important;
    }
}
</style>
@endpush
@endsection