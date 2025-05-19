@extends('ui.layout')

@section('title', 'Landlord Properties')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $landlord->name }}'s Properties</h4>
            <p class="text-muted mb-0">Browse properties owned by this landlord</p>
        </div>
        <a href="{{ route('contractor.find-landlords') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Landlords
        </a>
    </div>
    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Request Approval</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('contractor.request-approval') }}" method="POST">
                @csrf
                <input type="hidden" name="landlordID" value="{{ $landlord->userID }}">
                
                <div class="mb-3">
                    <label for="specialization" class="form-label">Your Specialization</label>
                    <select name="specialization" id="specialization" class="form-select @error('specialization') is-invalid @enderror" required>
                        <option value="">-- Select Specialization --</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Carpentry">Carpentry</option>
                        <option value="HVAC">HVAC</option>
                        <option value="General Maintenance">General Maintenance</option>
                        <option value="Painting">Painting</option>
                        <option value="Roofing">Roofing</option>
                        <option value="Landscaping">Landscaping</option>
                    </select>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="maintenance_scope" class="form-label">Maintenance Scope</label>
                    <textarea name="maintenance_scope" id="maintenance_scope" rows="4" class="form-control @error('maintenance_scope') is-invalid @enderror" placeholder="Describe your maintenance services, experience, and availability..." required></textarea>
                    @error('maintenance_scope')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Properties</h5>
        </div>
        <div class="card-body">
            @if($properties->count() > 0)
                <div class="row">
                    @foreach($properties as $property)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($property->house_image)
                                    <img src="{{ asset('storage/' . $property->house_image) }}" class="card-img-top" alt="{{ $property->house_address }}">
                                @else
                                    <div class="card-img-top bg-light text-center py-5">
                                        <i class="fas fa-home fa-4x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $property->house_address }}</h5>
                                    <p class="card-text">
                                        <i class="fas fa-door-open me-1"></i> {{ $property->house_number_room }} Rooms<br>
                                        <i class="fas fa-toilet me-1"></i> {{ $property->house_number_toilet }} Toilets
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <h5>No Properties Found</h5>
                    <p class="text-muted">This landlord doesn't have any properties yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection