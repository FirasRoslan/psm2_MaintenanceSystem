@extends('ui.layout')

@section('title', 'My Assigned Properties')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-2">My Properties</h2>
            <p class="text-muted mb-0 fs-5">Manage your assigned rental properties</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
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

<style>
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
</style>
@endsection