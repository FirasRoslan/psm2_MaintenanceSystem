@extends('ui.layout')

@section('title', 'Tenant House Assignment Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Tenant House Assignment Details</h4>
        <div>
            <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit me-1"></i>Edit Assignment
            </a>
            <a href="{{ route('landlord.tenants.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="initials">{{ substr($tenant->name, 0, 1) }}</span>
                        </div>
                        <h5 class="mb-0">{{ $tenant->name }}</h5>
                        <p class="text-muted">Tenant</p>
                        <span class="badge bg-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                            {{ ucfirst($tenant->approval_status) }}
                        </span>
                    </div>
                    
                    <div class="tenant-info">
                        <div class="d-flex mb-3">
                            <div class="icon-box me-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span>{{ $tenant->email }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="icon-box me-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Phone</small>
                                <span>{{ $tenant->phone }}</span>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="icon-box me-3">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Joined</small>
                                <span>{{ $tenant->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Assigned Property</h5>
                </div>
                <div class="card-body">
                    @if($houses->count() > 0)
                        @foreach($houses as $house)
                        <div class="property-card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/' . $house->house_image) }}" class="img-fluid rounded" alt="{{ $house->house_address }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $house->house_address }}</h5>
                                        <div class="d-flex mb-2">
                                            <div class="me-3">
                                                <small class="text-muted">Rooms</small>
                                                <p class="mb-0">{{ $house->house_number_room }}</p>
                                            </div>
                                            <div>
                                                <small class="text-muted">Bathrooms</small>
                                                <p class="mb-0">{{ $house->house_number_toilet }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted">Assignment Status</small>
                                            @php
                                                $status = $house->pivot->approval_status;
                                            @endphp
                                            
                                            @if($status === null)
                                                <p class="mb-0"><span class="badge bg-warning text-dark">Pending Approval</span></p>
                                            @elseif($status === true)
                                                <p class="mb-0"><span class="badge bg-success">Approved</span></p>
                                            @else
                                                <p class="mb-0"><span class="badge bg-danger">Rejected</span></p>
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('landlord.properties.show', $house->houseID) }}" class="btn btn-sm btn-outline-primary">View Property</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No properties assigned to this tenant.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 80px;
    height: 80px;
    background-color: #3498db;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.initials {
    font-size: 32px;
    color: white;
    font-weight: bold;
}

.icon-box {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.property-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}
</style>
@endsection