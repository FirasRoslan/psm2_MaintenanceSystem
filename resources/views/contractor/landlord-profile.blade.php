@extends('ui.layout')

@section('title', 'Landlord Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Landlord Profile</h4>
            <p class="text-muted mb-0">View details about this landlord</p>
        </div>
        <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5">
                    <div class="avatar-lg mx-auto mb-4 bg-primary text-white">
                        {{ substr($landlord->name, 0, 1) }}
                    </div>
                    <h4 class="mb-1">{{ $landlord->name }}</h4>
                    <p class="text-muted mb-3">Landlord</p>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <div class="px-3 border-end">
                            <h5 class="mb-0">{{ $landlord->houses->count() }}</h5>
                            <small class="text-muted">Properties</small>
                        </div>
                        <div class="px-3">
                            <h5 class="mb-0">{{ $landlord->approvedContractors->count() }}</h5>
                            <small class="text-muted">Contractors</small>
                        </div>
                    </div>
                    
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-box bg-primary-light me-3">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div class="text-start">
                                <p class="mb-0">{{ $landlord->email }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-light me-3">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div class="text-start">
                                <p class="mb-0">{{ $landlord->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Properties</h5>
                </div>
                <div class="card-body">
                    @if($landlord->houses->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($landlord->houses as $property)
                                <div class="list-group-item px-0 py-3 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="property-image rounded">
                                                @if($property->house_image)
                                                    <img src="{{ asset('storage/' . $property->house_image) }}" alt="{{ $property->house_address }}" class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 80px; height: 60px;">
                                                        <i class="fas fa-home fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $property->house_address }}</h6>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-door-open me-1"></i> {{ $property->house_number_room }} {{ Str::plural('room', $property->house_number_room) }}
                                                <i class="fas fa-toilet ms-2 me-1"></i> {{ $property->house_number_toilet }} {{ Str::plural('toilet', $property->house_number_toilet) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-building"></i>
                            </div>
                            <h5>No Properties</h5>
                            <p class="text-muted">This landlord hasn't added any properties yet.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Maintenance Agreement</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Maintenance Scope</h6>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-0">{{ $pivot->maintenance_scope ?? 'No maintenance scope defined' }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Your Specialization</h6>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-0">{{ $pivot->specialization ?? 'No specialization defined' }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <h6 class="text-muted mb-2">Agreement Status</h6>
                        @if(isset($pivot) && $pivot->approval_status === true)
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle me-2"></i> Your agreement with this landlord is active
                            </div>
                        @elseif(isset($pivot) && $pivot->approval_status === null)
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-clock me-2"></i> Your agreement is pending approval from the landlord
                            </div>
                        @else
                            <div class="alert alert-danger mb-0">
                                <i class="fas fa-times-circle me-2"></i> Your agreement with this landlord is not active
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .avatar-lg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
    }
    
    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
        color: #adb5bd;
    }
</style>
@endpush
@endsection