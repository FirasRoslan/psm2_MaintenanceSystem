@extends('ui.layout')

@section('title', 'Find Properties')

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
                                <a href="{{ route('tenant.dashboard') }}" class="text-white text-decoration-none opacity-75">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                Available Properties
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Title Section -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-container me-3">
                            <i class="fas fa-search text-white fa-2x"></i>
                        </div>
                        <div>
                            <h1 class="text-white fw-bold mb-1 display-6">Available Properties</h1>
                            <p class="text-white opacity-90 mb-0 fs-5">Discover and request rental properties</p>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tenant.dashboard') }}" class="btn btn-light rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Search Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm rounded-4 search-card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="search-icon-wrapper mb-3">
                            <div class="search-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center">
                                <i class="fas fa-search text-primary fa-lg"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Find Your Perfect Home</h4>
                        <p class="text-muted mb-0">Search properties by address to find your ideal rental</p>
                    </div>
                    
                    <form method="GET" action="{{ route('tenant.find-houses') }}" class="search-form">
                        <div class="position-relative">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0 ps-4">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Enter property address (e.g., 123 Main Street, City)"
                                       autocomplete="off">
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @if($search)
                        <div class="mt-3 d-flex align-items-center justify-content-between">
                            <div class="search-results-info">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Showing results for: <strong>"{{ $search }}"</strong>
                                </small>
                            </div>
                            <a href="{{ route('tenant.find-houses') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="fas fa-times me-1"></i>Clear Search
                            </a>
                        </div>
                    @endif
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
    
    <!-- Results Header -->
    @if($houses->count() > 0)
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold text-dark mb-1">
                    @if($search)
                        Search Results
                    @else
                        All Available Properties
                    @endif
                </h5>
                <p class="text-muted mb-0">{{ $houses->count() }} {{ $houses->count() == 1 ? 'property' : 'properties' }} found</p>
            </div>
        </div>
        
        <!-- Properties Grid -->
        <div class="row">
            @foreach($houses as $house)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden hover-lift property-card">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $house->house_image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $house->house_address }}" 
                                 style="height: 220px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill shadow">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </span>
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
                            <form action="{{ route('tenant.request-house') }}" method="POST">
                                @csrf
                                <input type="hidden" name="houseID" value="{{ $house->houseID }}">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                    <i class="fas fa-paper-plane me-2"></i>Request Assignment
                                </button>
                            </form>
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
                            @if($search)
                                <i class="fas fa-search-minus fa-3x text-muted"></i>
                            @else
                                <i class="fas fa-search fa-3x text-muted"></i>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-3">
                            @if($search)
                                No Properties Found
                            @else
                                No Properties Available
                            @endif
                        </h4>
                        <p class="text-muted mb-4">
                            @if($search)
                                No properties match your search for "{{ $search }}". Try adjusting your search terms or browse all available properties.
                            @else
                                No properties are available at the moment. Please check back later or contact support for assistance.
                            @endif
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            @if($search)
                                <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-list me-2"></i>View All Properties
                                </a>
                            @endif
                            <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-home me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

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
    
    /* Existing styles for search card and other elements */
    .search-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .search-icon {
        width: 60px;
        height: 60px;
    }

    .search-form .form-control {
        border: 2px solid #e9ecef;
        border-radius: 50px;
        padding: 12px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .search-form .input-group-text {
        border: 2px solid #e9ecef;
        border-radius: 50px 0 0 50px;
        background: transparent;
    }

    .search-form .btn {
        border-radius: 0 50px 50px 0;
        border: 2px solid #0d6efd;
        padding: 12px 24px;
    }

    .property-card {
        transition: all 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }

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

    .search-results-info {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
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
        
        .search-form .input-group {
            flex-direction: column;
        }
        
        .search-form .input-group-text,
        .search-form .form-control,
        .search-form .btn {
            border-radius: 25px;
            border: 2px solid #e9ecef;
        }
        
        .search-form .btn {
            margin-top: 10px;
            border-color: #0d6efd;
        }
    }
</style>
@endpush

<script>
// Add some interactive features
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus search input when page loads
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
    
    // Add search suggestions or auto-complete functionality here if needed
    // You can enhance this further with AJAX-based suggestions
});
</script>
@endsection