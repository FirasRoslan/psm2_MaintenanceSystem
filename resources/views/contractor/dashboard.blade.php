@extends('ui.layout')

@section('title', 'Contractor Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header bg-gradient-primary text-white rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 fw-bold">Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}!</h2>
                        <p class="mb-0 opacity-90">{{ date('l, F j, Y') }}</p>
                    </div>
                    <div class="text-end">
                        <div class="welcome-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-white bg-opacity-10 rounded-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Welcome to your Contractor Dashboard. Efficiently manage your maintenance services all in one place.</span>
                    </div>
                </div>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
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
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                    </div>
                    <div>
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- New Approval Notifications -->
            @if(isset($recentlyApprovedLandlords) && $recentlyApprovedLandlords->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 bg-gradient-success text-white mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="notification-icon">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1 fw-bold">🎉 New Approvals</h5>
                            <p class="mb-3 opacity-90">
                                @if($recentlyApprovedLandlords->count() == 1)
                                    <strong>{{ $recentlyApprovedLandlords->first()->name }}</strong> has approved your request to be their maintenance contractor.
                                @else
                                    <strong>{{ $recentlyApprovedLandlords->count() }}</strong> landlords have approved your requests recently.
                                @endif
                            </p>
                            <div>
                                @foreach($recentlyApprovedLandlords as $landlord)
                                    <a href="{{ route('contractor.landlord-profile', $landlord->userID) }}" class="btn btn-light btn-sm rounded-pill px-4 me-2 mb-2">
                                        <i class="fas fa-user me-1"></i> View {{ $landlord->name }}'s Profile
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold">Quick Actions</h4>
                <span class="text-muted">Manage your contractor services</span>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card action-card">
                <div class="card-body p-4 text-center">
                    <div class="action-icon bg-primary-light mb-3">
                        <i class="fas fa-search text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-2">Find Landlords</h5>
                    <p class="card-text text-muted mb-4">Discover available landlords and expand your client base</p>
                    <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary rounded-pill px-4 w-100">
                        <i class="fas fa-search me-2"></i>Find Landlords
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card action-card">
                <div class="card-body p-4 text-center">
                    <div class="action-icon bg-warning-light mb-3">
                        <i class="fas fa-tasks text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-2">My Tasks</h5>
                    <p class="card-text text-muted mb-4">View and manage your assigned maintenance tasks</p>
                    <a href="{{ route('contractor.tasks') }}" class="btn btn-warning rounded-pill px-4 w-100">
                        <i class="fas fa-tasks me-2"></i>View Tasks
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card action-card">
                <div class="card-body p-4 text-center">
                    <div class="action-icon bg-info-light mb-3">
                        <i class="fas fa-paper-plane text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-2">My Requests</h5>
                    <p class="card-text text-muted mb-4">Track maintenance requests and check their status</p>
                    <a href="{{ route('contractor.requests') }}" class="btn btn-info rounded-pill px-4 w-100">
                        <i class="fas fa-paper-plane me-2"></i>View Requests
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card action-card">
                <div class="card-body p-4 text-center">
                    <div class="action-icon bg-success-light mb-3">
                        <i class="fas fa-user text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-2">My Profile</h5>
                    <p class="card-text text-muted mb-4">Update your information and specializations</p>
                    <a href="#" class="btn btn-success rounded-pill px-4 w-100">
                        <i class="fas fa-user me-2"></i>View Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Section -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success-light me-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Approved Landlords</h5>
                                <small class="text-muted">Your active partnerships</small>
                            </div>
                        </div>
                        <span class="badge bg-success rounded-pill fs-6 px-3 py-2">{{ $approvedLandlords->count() }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($approvedLandlords->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($approvedLandlords as $landlord)
                                <div class="list-group-item border-0 p-4 landlord-item">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-md me-3 bg-success text-white">
                                            {{ substr($landlord->name, 0, 1) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $landlord->name }}</h6>
                                            <small class="text-muted">{{ $landlord->email }}</small>
                                        </div>
                                        <div class="status-badge">
                                            <span class="badge bg-success-light text-success rounded-pill">
                                                <i class="fas fa-check me-1"></i>Active
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <span class="text-muted small">Specialization:</span>
                                                    <span class="badge bg-primary rounded-pill ms-2">{{ $landlord->pivot->specialization }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <span class="text-muted small">Scope:</span>
                                                    <span class="ms-2 small">{{ Str::limit($landlord->pivot->maintenance_scope, 50) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('contractor.landlord-profile', $landlord->userID) }}" class="btn btn-sm btn-outline-primary rounded-pill flex-fill">
                                            <i class="fas fa-user me-1"></i> Profile
                                        </a>
                                        <a href="{{ route('contractor.landlord-properties', $landlord->userID) }}" class="btn btn-sm btn-primary rounded-pill flex-fill">
                                            <i class="fas fa-building me-1"></i> Properties
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($approvedLandlords->count() > 3)
                        <div class="card-footer bg-light border-0 text-center">
                            <a href="#" class="btn btn-link text-decoration-none">
                                <i class="fas fa-chevron-down me-1"></i> View All Approved Landlords
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <h5 class="fw-bold">No Approved Landlords</h5>
                            <p class="text-muted mb-4">Start building your client base by finding landlords</p>
                            <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Find Landlords
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning-light me-3">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Pending Requests</h5>
                                <small class="text-muted">Awaiting landlord approval</small>
                            </div>
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill fs-6 px-3 py-2">{{ $pendingRequests->count() }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pendingRequests->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($pendingRequests as $request)
                                <div class="list-group-item border-0 p-4 request-item">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-md me-3 bg-warning text-dark">
                                            {{ substr($request->name, 0, 1) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $request->name }}</h6>
                                            <small class="text-muted">{{ $request->email }}</small>
                                        </div>
                                        <div class="status-badge">
                                            <span class="badge bg-warning-light text-warning rounded-pill">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <span class="text-muted small">Specialization:</span>
                                                    <span class="badge bg-primary rounded-pill ms-2">{{ $request->pivot->specialization }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <span class="text-muted small">Scope:</span>
                                                    <span class="ms-2 small">{{ Str::limit($request->pivot->maintenance_scope, 50) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <span class="badge bg-warning-light text-warning rounded-pill px-3 py-2">
                                            <i class="fas fa-hourglass-half me-1"></i> Awaiting Response
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($pendingRequests->count() > 3)
                        <div class="card-footer bg-light border-0 text-center">
                            <a href="{{ route('contractor.requests') }}" class="btn btn-link text-decoration-none">
                                <i class="fas fa-chevron-down me-1"></i> View All Pending Requests
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h5 class="fw-bold">No Pending Requests</h5>
                            <p class="text-muted mb-4">All your requests have been processed</p>
                            <a href="{{ route('contractor.find-landlords') }}" class="btn btn-outline-primary rounded-pill px-4">
                                <i class="fas fa-plus me-2"></i>Send New Request
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Modern Color Palette */
    :root {
        --primary-color: #6366f1;
        --primary-light: #e0e7ff;
        --success-color: #10b981;
        --success-light: #d1fae5;
        --warning-color: #f59e0b;
        --warning-light: #fef3c7;
        --info-color: #06b6d4;
        --info-light: #cffafe;
        --danger-color: #ef4444;
        --danger-light: #fee2e2;
    }

    /* Enhanced Border Radius */
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    /* Gradient Backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #4f46e5 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
    }

    /* Welcome Header */
    .welcome-header {
        position: relative;
        overflow: hidden;
    }
    
    .welcome-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    /* Action Cards */
    .action-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
    }
    
    .action-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto;
    }

    /* Color Variants */
    .bg-primary-light {
        background-color: var(--primary-light) !important;
    }
    
    .bg-success-light {
        background-color: var(--success-light) !important;
    }
    
    .bg-warning-light {
        background-color: var(--warning-light) !important;
    }
    
    .bg-info-light {
        background-color: var(--info-light) !important;
    }
    
    .text-primary {
        color: var(--primary-color) !important;
    }
    
    .text-success {
        color: var(--success-color) !important;
    }
    
    .text-warning {
        color: var(--warning-color) !important;
    }
    
    .text-info {
        color: var(--info-color) !important;
    }

    /* Button Styles */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
    }
    
    .btn-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
        transform: translateY(-1px);
    }
    
    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }
    
    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }
    
    .btn-info {
        background-color: var(--info-color);
        border-color: var(--info-color);
    }

    /* Icon Boxes */
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Avatars */
    .avatar-md {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* List Items */
    .landlord-item, .request-item {
        transition: background-color 0.2s ease;
        border-radius: 0.5rem;
        margin: 0.25rem;
    }
    
    .landlord-item:hover, .request-item:hover {
        background-color: #f8fafc;
    }

    /* Info Items */
    .info-item {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    /* Status Badges */
    .status-badge .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    /* Empty State */
    .empty-state-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2.5rem;
        color: #64748b;
    }

    /* Notification Icon */
    .notification-icon {
        width: 70px;
        height: 70px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Card Enhancements */
    .card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    /* Badge Enhancements */
    .badge {
        font-weight: 500;
    }
    
    .bg-success-light {
        background-color: var(--success-light) !important;
        color: var(--success-color) !important;
    }
    
    .bg-warning-light {
        background-color: var(--warning-light) !important;
        color: var(--warning-color) !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .action-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .welcome-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .notification-icon {
            width: 60px;
            height: 60px;
        }
    }
</style>
@endpush
@endsection