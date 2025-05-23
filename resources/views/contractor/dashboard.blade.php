@extends('ui.layout')

@section('title', 'Contractor Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Contractor Dashboard</h4>
                    <p class="text-muted mb-0">Manage your maintenance services</p>
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
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="notification-icon">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">New Approvals</h5>
                                <p class="mb-3 opacity-75">
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
            </div>
            @endif
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-search"></i>
                            </div>
                            <h5 class="card-title">Find Landlords</h5>
                            <p class="card-text text-muted mb-4">Browse landlords and request to be their maintenance contractor.</p>
                            <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Find Landlords
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5 class="card-title">My Tasks</h5>
                            <p class="card-text text-muted mb-4">View and manage your assigned maintenance tasks.</p>
                            <a href="{{ route('contractor.tasks') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-tasks me-2"></i>View Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <h5 class="card-title">My Requests</h5>
                            <p class="card-text text-muted mb-4">Manage your landlord approval requests and check their status.</p>
                            <a href="{{ route('contractor.requests') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-paper-plane me-2"></i>View Requests
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Approved Landlords</h5>
                            <span class="badge bg-primary rounded-pill">{{ $approvedLandlords->count() }}</span>
                        </div>
                        <div class="card-body p-0">
                            @if($approvedLandlords->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($approvedLandlords as $landlord)
                                        <div class="list-group-item border-0 p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-sm me-3 bg-primary text-white">
                                                    {{ substr($landlord->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $landlord->name }}</h6>
                                                    <small class="text-muted">{{ $landlord->email }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex mb-2">
                                                    <div class="text-muted me-2">Scope:</div>
                                                    <div>{{ $landlord->pivot->maintenance_scope }}</div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="text-muted me-2">Specialization:</div>
                                                    <div><span class="badge bg-primary rounded-pill">{{ $landlord->pivot->specialization }}</span></div>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <a href="{{ route('contractor.landlord-profile', $landlord->userID) }}" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                                    <i class="fas fa-user me-1"></i> View Profile
                                                </a>
                                                <a href="{{ route('contractor.landlord-properties', $landlord->userID) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="fas fa-building me-1"></i> View Properties
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="empty-state-icon mb-3">
                                        <i class="fas fa-user-times"></i>
                                    </div>
                                    <h5>No Approved Landlords</h5>
                                    <p class="text-muted mb-4">You don't have any approved landlords yet.</p>
                                    <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-search me-2"></i>Find Landlords
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pending Requests</h5>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $pendingRequests->count() }}</span>
                        </div>
                        <div class="card-body p-0">
                            @if($pendingRequests->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($pendingRequests as $request)
                                        <div class="list-group-item border-0 p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-sm me-3 bg-warning text-dark">
                                                    {{ substr($request->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $request->name }}</h6>
                                                    <small class="text-muted">{{ $request->email }}</small>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex mb-2">
                                                    <div class="text-muted me-2">Scope:</div>
                                                    <div>{{ $request->pivot->maintenance_scope }}</div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="text-muted me-2">Specialization:</div>
                                                    <div><span class="badge bg-primary rounded-pill">{{ $request->pivot->specialization }}</span></div>
                                                </div>
                                            </div>
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                <i class="fas fa-clock me-1"></i> Pending Approval
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="empty-state-icon mb-3">
                                        <i class="fas fa-hourglass"></i>
                                    </div>
                                    <h5>No Pending Requests</h5>
                                    <p class="text-muted">You don't have any pending requests.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Modern styling */
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .notification-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        background-color: #e0f2fe;
        color: #0ea5e9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
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
    
    .btn-primary {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
    }
    
    .btn-primary:hover {
        background-color: #0284c7;
        border-color: #0284c7;
    }
    
    .btn-outline-primary {
        color: #0ea5e9;
        border-color: #0ea5e9;
    }
    
    .btn-outline-primary:hover {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
    }
    
    .bg-primary {
        background-color: #0ea5e9 !important;
    }
    
    .text-primary {
        color: #0ea5e9 !important;
    }
</style>
@endpush
@endsection