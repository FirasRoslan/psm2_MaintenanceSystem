@extends('ui.layout')

@section('title', 'Landlord Properties')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section with Card Design -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="page-title-section">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('contractor.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('contractor.find-landlords') }}" class="text-decoration-none">Find Landlords</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $landlord->name }}'s Properties</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-building me-3"></i>{{ $landlord->name }}'s Properties
                    </h1>
                    <p class="page-subtitle mb-0">Browse properties and submit maintenance contractor request</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('contractor.find-landlords') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Landlords
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-exclamation-circle fa-lg text-danger"></i>
            </div>
            <div>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-exclamation-triangle fa-lg text-danger"></i>
            </div>
            <div>
                <strong>Validation Error!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Request Approval</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('contractor.request-approval') }}" method="POST" id="approvalForm">
                @csrf
                <input type="hidden" name="landlordID" value="{{ $landlord->userID }}">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Your Specializations <span class="text-danger">*</span></label>
                    <p class="text-muted small mb-3">Select all specializations that apply to your services</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Plumbing" id="plumbing" {{ in_array('Plumbing', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="plumbing">
                                    <i class="fas fa-wrench me-2 text-primary"></i>Plumbing
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Electrical" id="electrical" {{ in_array('Electrical', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="electrical">
                                    <i class="fas fa-bolt me-2 text-warning"></i>Electrical
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Carpentry" id="carpentry" {{ in_array('Carpentry', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="carpentry">
                                    <i class="fas fa-hammer me-2 text-info"></i>Carpentry
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="HVAC" id="hvac" {{ in_array('HVAC', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hvac">
                                    <i class="fas fa-fan me-2 text-success"></i>HVAC
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="General Maintenance" id="general" {{ in_array('General Maintenance', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="general">
                                    <i class="fas fa-tools me-2 text-secondary"></i>General Maintenance
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Painting" id="painting" {{ in_array('Painting', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="painting">
                                    <i class="fas fa-paint-roller me-2 text-danger"></i>Painting
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Roofing" id="roofing" {{ in_array('Roofing', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="roofing">
                                    <i class="fas fa-home me-2 text-dark"></i>Roofing
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="specializations[]" value="Landscaping" id="landscaping" {{ in_array('Landscaping', old('specializations', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="landscaping">
                                    <i class="fas fa-leaf me-2 text-success"></i>Landscaping
                                </label>
                            </div>
                        </div>
                    </div>
                    @error('specializations')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="maintenance_scope" class="form-label fw-semibold">Maintenance Scope <span class="text-danger">*</span></label>
                    <textarea name="maintenance_scope" id="maintenance_scope" rows="4" class="form-control @error('maintenance_scope') is-invalid @enderror" placeholder="Describe your maintenance services, experience, and availability..." required>{{ old('maintenance_scope') }}</textarea>
                    @error('maintenance_scope')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane me-2"></i>Send Request
                        </span>
                        <span class="btn-loading d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Sending...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-building me-2"></i>Properties</h5>
        </div>
        <div class="card-body">
            @if($properties->count() > 0)
                <div class="row">
                    @foreach($properties as $property)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm rounded-3">
                                @if($property->house_image)
                                    <img src="{{ asset('storage/' . $property->house_image) }}" class="card-img-top rounded-top-3" alt="{{ $property->house_address }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light text-center py-5 rounded-top-3" style="height: 200px;">
                                        <i class="fas fa-home fa-4x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $property->house_address }}</h5>
                                    <div class="row text-center mt-3">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-door-open me-2 text-primary"></i>
                                                <span class="fw-semibold">{{ $property->house_number_room }}</span>
                                            </div>
                                            <small class="text-muted">Rooms</small>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fas fa-toilet me-2 text-info"></i>
                                                <span class="fw-semibold">{{ $property->house_number_toilet }}</span>
                                            </div>
                                            <small class="text-muted">Toilets</small>
                                        </div>
                                    </div>
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

<style>
/* Enhanced Header Styling */
.page-header {
    margin-bottom: 2rem;
}

.page-title-section .breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
    font-size: 0.875rem;
}

.page-title-section .breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: #6c757d;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1rem;
}

.page-actions .btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
}

/* Enhanced Form Styling */
.form-check {
    padding: 0.75rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.form-check:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-check-input:checked ~ .form-check-label {
    color: #0d6efd;
    font-weight: 500;
}

.form-check-label {
    cursor: pointer;
    width: 100%;
    margin-bottom: 0;
}

/* Card Enhancements */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-weight: 600;
}

/* Button Styling */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.4);
}

/* Alert Styling */
.alert {
    border: none;
    border-radius: 12px;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

/* Validation Styling */
.text-danger {
    font-size: 0.875rem;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Loading Button */
.btn-loading {
    pointer-events: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-actions {
        margin-top: 1rem;
        text-align: left !important;
    }
    
    .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>

<script>
// Enhanced form validation and feedback
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('approvalForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    const checkboxes = document.querySelectorAll('input[name="specializations[]"]');
    
    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('input[name="specializations[]"]:checked');
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one specialization.');
            return false;
        }
        
        // Show loading state
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        submitBtn.disabled = true;
    });
    
    // Add visual feedback for checkbox selection
    checkboxes.forEach(checkbox => {
        // Set initial state based on checked status
        updateCheckboxStyle(checkbox);
        
        checkbox.addEventListener('change', function() {
            updateCheckboxStyle(this);
        });
    });
    
    function updateCheckboxStyle(checkbox) {
        const formCheck = checkbox.closest('.form-check');
        if (checkbox.checked) {
            formCheck.style.backgroundColor = '#e7f3ff';
            formCheck.style.borderColor = '#0d6efd';
        } else {
            formCheck.style.backgroundColor = '';
            formCheck.style.borderColor = '#e9ecef';
        }
    }
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection