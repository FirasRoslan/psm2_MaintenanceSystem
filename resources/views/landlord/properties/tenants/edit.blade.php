@extends('ui.layout')

@section('title', 'Edit Tenant Assignment')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.tenants.index') }}" class="text-decoration-none">Tenants</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit {{ $tenant->name }}</li>
            </ol>
        </nav>
        <h2 class="mb-1 fw-bold">Edit Tenant Assignment</h2>
        <p class="text-muted mb-0">Update tenant information and property assignment</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-3">
                            <span class="initials">{{ substr($tenant->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold">{{ $tenant->name }}</h5>
                            <small class="text-muted">Update tenant information and assignments</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('landlord.tenants.update', $tenant->userID) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Personal Information Section -->
                            <div class="col-12">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-user me-2"></i>Personal Information
                                </h6>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $tenant->name) }}" 
                                           placeholder="Full Name"
                                           required>
                                    <label for="name">Full Name *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $tenant->email) }}" 
                                           placeholder="Email Address"
                                           required>
                                    <label for="email">Email Address *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $tenant->phone) }}" 
                                           placeholder="Phone Number"
                                           required>
                                    <label for="phone">Phone Number *</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('approval_status') is-invalid @enderror" 
                                            id="approval_status" 
                                            name="approval_status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ (old('approval_status', $tenant->approval_status) == 'active') ? 'selected' : '' }}>Active</option>
                                        <option value="non active" {{ (old('approval_status', $tenant->approval_status) == 'non active') ? 'selected' : '' }}>Non Active</option>
                                    </select>
                                    <label for="approval_status">Account Status *</label>
                                    @error('approval_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Property Assignment Section -->
                            <div class="col-12">
                                <hr class="my-4">
                                <h6 class="text-muted mb-3">
                                    <i class="fas fa-home me-2"></i>Property Assignment
                                </h6>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('house_id') is-invalid @enderror" 
                                            id="house_id" 
                                            name="house_id" 
                                            required>
                                        <option value="">Select Property</option>
                                        @foreach($houses as $house)
                                        <option value="{{ $house->houseID }}" 
                                            {{ (old('house_id') == $house->houseID || in_array($house->houseID, $assignedHouses)) ? 'selected' : '' }}>
                                            {{ $house->house_address }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="house_id">Assign to Property *</label>
                                    @error('house_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('assignment_status') is-invalid @enderror" 
                                            id="assignment_status" 
                                            name="assignment_status" 
                                            required>
                                        @php
                                            $currentStatus = 'pending';
                                            if ($tenant->tenantHouses->count() > 0) {
                                                $pivotStatus = $tenant->tenantHouses->first()->pivot->approval_status;
                                                if ($pivotStatus === true) {
                                                    $currentStatus = 'approve';
                                                } elseif ($pivotStatus === false) {
                                                    $currentStatus = 'reject';
                                                }
                                            }
                                        @endphp
                                        <option value="pending" {{ (old('assignment_status', $currentStatus) == 'pending') ? 'selected' : '' }}>Pending</option>
                                        <option value="approve" {{ (old('assignment_status', $currentStatus) == 'approve') ? 'selected' : '' }}>Approved</option>
                                        <option value="reject" {{ (old('assignment_status', $currentStatus) == 'reject') ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <label for="assignment_status">Assignment Status *</label>
                                    @error('assignment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('landlord.tenants.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Update Tenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-floating > .form-control:focus,
.form-floating > .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color), 0.25);
}

.form-floating > label {
    color: var(--text-muted);
}

.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
}

.breadcrumb-item a {
    color: var(--primary-color);
}

.breadcrumb-item a:hover {
    color: var(--primary-dark);
}

.card {
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.btn-lg {
    border-radius: 12px;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endpush
@endsection