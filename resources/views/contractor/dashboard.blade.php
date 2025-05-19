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
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">Find Landlords</h5>
                            <p class="card-text">Browse landlords and request to be their maintenance contractor.</p>
                            <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Find Landlords
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">My Tasks</h5>
                            <p class="card-text">View and manage your assigned maintenance tasks.</p>
                            <a href="{{ route('contractor.tasks') }}" class="btn btn-primary">
                                <i class="fas fa-tasks me-2"></i>View Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Approved Landlords</h5>
                        </div>
                        <div class="card-body">
                            @if($approvedLandlords->count() > 0)
                                <div class="list-group">
                                    @foreach($approvedLandlords as $landlord)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $landlord->name }}</h6>
                                                <small>{{ $landlord->email }}</small>
                                            </div>
                                            <p class="mb-1"><strong>Scope:</strong> {{ $landlord->pivot->maintenance_scope }}</p>
                                            <p class="mb-1"><strong>Specialization:</strong> {{ $landlord->pivot->specialization }}</p>
                                            <a href="{{ route('contractor.landlord-properties', $landlord->userID) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-building me-1"></i> View Properties
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-times fa-3x text-muted mb-3"></i>
                                    <p>You don't have any approved landlords yet.</p>
                                    <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Find Landlords
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Pending Requests</h5>
                        </div>
                        <div class="card-body">
                            @if($pendingRequests->count() > 0)
                                <div class="list-group">
                                    @foreach($pendingRequests as $request)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $request->name }}</h6>
                                                <small>{{ $request->email }}</small>
                                            </div>
                                            <p class="mb-1"><strong>Scope:</strong> {{ $request->pivot->maintenance_scope }}</p>
                                            <p class="mb-1"><strong>Specialization:</strong> {{ $request->pivot->specialization }}</p>
                                            <span class="badge bg-warning text-dark">Pending Approval</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-hourglass-half fa-3x text-muted mb-3"></i>
                                    <p>You don't have any pending requests.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection