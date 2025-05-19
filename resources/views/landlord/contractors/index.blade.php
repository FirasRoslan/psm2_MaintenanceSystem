@extends('ui.layout')

@section('title', 'Manage Contractors')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manage Contractors</h4>
            <p class="text-muted mb-0">Approve or reject contractor requests and manage your contractors</p>
        </div>
        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
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
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Pending Requests</h5>
                </div>
                <div class="card-body">
                    @if($pendingRequests->count() > 0)
                        <div class="list-group">
                            @foreach($pendingRequests as $contractor)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $contractor->name }}</h6>
                                        <small>{{ $contractor->email }}</small>
                                    </div>
                                    <p class="mb-1"><strong>Specialization:</strong> {{ $contractor->pivot->specialization }}</p>
                                    <p class="mb-1"><strong>Scope:</strong> {{ $contractor->pivot->maintenance_scope }}</p>
                                    <div class="d-flex mt-2">
                                        <form action="{{ route('landlord.contractors.approve', $contractor->userID) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('landlord.contractors.reject', $contractor->userID) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                            <p>No pending contractor requests.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Approved Contractors</h5>
                </div>
                <div class="card-body">
                    @if($approvedContractors->count() > 0)
                        <div class="list-group">
                            @foreach($approvedContractors as $contractor)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $contractor->name }}</h6>
                                        <small>{{ $contractor->email }}</small>
                                    </div>
                                    <p class="mb-1"><strong>Specialization:</strong> {{ $contractor->pivot->specialization }}</p>
                                    <p class="mb-1"><strong>Scope:</strong> {{ $contractor->pivot->maintenance_scope }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-hard-hat fa-3x text-muted mb-3"></i>
                            <p>No approved contractors yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection