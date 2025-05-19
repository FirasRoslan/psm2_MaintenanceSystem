@extends('ui.layout')

@section('title', 'Manage Contractors')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manage Contractors</h4>
            <p class="text-muted mb-0">Approve or reject contractor requests and manage your contractors</p>
        </div>
        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
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

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Pending Requests</h5>
                </div>
                <div class="card-body p-0">
                    @if($pendingRequests->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($pendingRequests as $contractor)
                                <div class="list-group-item border-0 p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 bg-warning text-dark">
                                            {{ substr($contractor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $contractor->name }}</h6>
                                            <small class="text-muted">{{ $contractor->email }}</small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex mb-2">
                                            <div class="text-muted me-2">Scope:</div>
                                            <div>{{ $contractor->pivot->maintenance_scope }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="text-muted me-2">Specialization:</div>
                                            <div><span class="badge bg-primary rounded-pill">{{ $contractor->pivot->specialization }}</span></div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <form action="{{ route('landlord.contractors.approve', $contractor->userID) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                                <i class="fas fa-check me-2"></i>Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('landlord.contractors.reject', $contractor->userID) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                                <i class="fas fa-times me-2"></i>Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <h5>No Pending Requests</h5>
                            <p class="text-muted">You don't have any pending contractor requests.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Approved Contractors</h5>
                    <span class="badge bg-primary rounded-pill">{{ $approvedContractors->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($approvedContractors->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($approvedContractors as $contractor)
                                <div class="list-group-item border-0 p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3 bg-primary text-white">
                                            {{ substr($contractor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $contractor->name }}</h6>
                                            <small class="text-muted">{{ $contractor->email }}</small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex mb-2">
                                            <div class="text-muted me-2">Scope:</div>
                                            <div>{{ $contractor->pivot->maintenance_scope }}</div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <div class="text-muted me-2">Specialization:</div>
                                            <div><span class="badge bg-primary rounded-pill">{{ $contractor->pivot->specialization }}</span></div>
                                        </div>
                                    </div>
                                    <a href="{{ route('landlord.contractors.show', $contractor->userID) }}" class="btn btn-outline-primary rounded-pill px-4">
                                        <i class="fas fa-eye me-2"></i>View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-user-hard-hat"></i>
                            </div>
                            <h5>No Approved Contractors</h5>
                            <p class="text-muted">You don't have any approved contractors yet.</p>
                        </div>
                    @endif
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