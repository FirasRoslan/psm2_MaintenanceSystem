@extends('ui.layout')

@section('title', 'Tenant Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Tenant Dashboard</h4>
                    <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}</p>
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
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ auth()->user()->name }}</h5>
                    <p class="card-text">This is your tenant management dashboard.</p>
                    
                    @if($approvedHouses->count() == 0 && $pendingHouses->count() == 0)
                        <div class="alert alert-info">
                            <p>You are not assigned to any property yet. Find a property to request assignment.</p>
                            <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-search"></i> Find Properties
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Pending House Requests -->
            @if($pendingHouses->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Pending Property Requests</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Property Address</th>
                                        <th>Landlord</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingHouses as $house)
                                        <tr>
                                            <td>{{ $house->house_address }}</td>
                                            <td>{{ $house->user->name }}</td>
                                            <td><span class="badge bg-warning text-dark">Pending Approval</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Approved Houses -->
            @if($approvedHouses->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Your Approved Properties</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Property Address</th>
                                        <th>Landlord</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedHouses as $house)
                                        <tr>
                                            <td>{{ $house->house_address }}</td>
                                            <td>{{ $house->user->name }}</td>
                                            <td>
                                                <a href="{{ route('tenant.properties.show', $house->houseID) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Rejected Houses -->
            @if($rejectedHouses->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Rejected Property Requests</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Property Address</th>
                                        <th>Landlord</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rejectedHouses as $house)
                                        <tr>
                                            <td>{{ $house->house_address }}</td>
                                            <td>{{ $house->user->name }}</td>
                                            <td><span class="badge bg-danger">Rejected</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="text-center mt-4">
                <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Find More Properties
                </a>
                <a href="{{ route('tenant.reports.index') }}" class="btn btn-info ms-2">
                    <i class="fas fa-tools"></i> View Maintenance Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection