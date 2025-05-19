@extends('ui.layout')

@section('title', 'Find Landlords')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Find Landlords</h4>
            <p class="text-muted mb-0">Browse landlords and request to be their maintenance contractor</p>
        </div>
        <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>
    
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
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($landlords->count() > 0)
                <div class="row">
                    @foreach($landlords as $landlord)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $landlord->name }}</h5>
                                    <p class="card-text text-muted">{{ $landlord->email }}</p>
                                    <a href="{{ route('contractor.landlord-properties', $landlord->userID) }}" class="btn btn-primary">
                                        <i class="fas fa-building me-2"></i>View Properties
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>No Landlords Found</h5>
                    <p class="text-muted">There are no landlords registered in the system yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection