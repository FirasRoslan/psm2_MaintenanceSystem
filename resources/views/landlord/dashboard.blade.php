@extends('ui.layout')

@section('title', 'Landlord Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">Today, {{ now()->format('M d, Y') }}</h4>
            <div class="alert alert-info">
                <i class="fas fa-bell me-2"></i> Welcome to your dashboard · Manage your properties, tenants, and maintenance requests here
            </div>
            
            <!-- Tenant request notification -->
            @if($pendingRequestsCount > 0)
            <div class="alert alert-warning border-0 shadow-sm mt-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-clock fa-2x text-warning me-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Pending Tenant Requests</h5>
                        <p class="mb-2">You have {{ $pendingRequestsCount }} pending tenant house assignment {{ Str::plural('request', $pendingRequestsCount) }}.</p>
                        <a href="{{ route('landlord.tenants.index') }}" class="btn btn-warning btn-sm px-4">
                            <i class="fas fa-users me-1"></i> View Requests
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Contractor request notification -->
            @if($pendingContractorCount > 0)
            <div class="alert alert-warning border-0 shadow-sm mt-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-hard-hat fa-2x text-warning me-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Pending Contractor Requests</h5>
                        <p class="mb-2">You have {{ $pendingContractorCount }} pending contractor {{ Str::plural('request', $pendingContractorCount) }}.</p>
                        <a href="{{ route('landlord.contractors.index') }}" class="btn btn-warning btn-sm px-4">
                            <i class="fas fa-hard-hat me-1"></i> View Requests
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Property Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3">Property Overview</h5>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary-light me-3">
                        <i class="fas fa-building text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Properties</h6>
                        <h3 class="mb-0">{{ $propertiesCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success-light me-3">
                        <i class="fas fa-door-open text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Rooms</h6>
                        <h3 class="mb-0">{{ $totalRooms }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-info-light me-3">
                        <i class="fas fa-toilet text-info"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Toilets</h6>
                        <h3 class="mb-0">{{ $totalToilets }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning-light me-3">
                        <i class="fas fa-users text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Active Tenants</h6>
                        <h3 class="mb-0">{{ $approvedTenantsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3">Maintenance Overview</h5>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-box bg-warning-light mx-auto mb-3">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <h6 class="text-muted mb-2">Pending</h6>
                    <h3 class="mb-0">{{ $pendingMaintenanceCount }}</h3>
                    <p class="text-muted mt-2 mb-0">Maintenance requests</p>
                    @if($pendingMaintenanceCount > 0)
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-sm btn-outline-warning mt-3">View All</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-box bg-info-light mx-auto mb-3">
                        <i class="fas fa-tools text-info"></i>
                    </div>
                    <h6 class="text-muted mb-2">In Progress</h6>
                    <h3 class="mb-0">{{ $inProgressMaintenanceCount }}</h3>
                    <p class="text-muted mt-2 mb-0">Maintenance requests</p>
                    @if($inProgressMaintenanceCount > 0)
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-sm btn-outline-info mt-3">View All</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-box bg-success-light mx-auto mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <h6 class="text-muted mb-2">Completed</h6>
                    <h3 class="mb-0">{{ $completedMaintenanceCount }}</h3>
                    <p class="text-muted mt-2 mb-0">Maintenance requests</p>
                    @if($completedMaintenanceCount > 0)
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-sm btn-outline-success mt-3">View All</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Properties -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Properties</h5>
                    <a href="{{ route('landlord.properties.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentProperties->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentProperties as $property)
                                <div class="list-group-item px-0 py-3 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="property-image rounded">
                                                @if($property->house_image)
                                                    <img src="{{ asset('storage/' . $property->house_image) }}" alt="{{ $property->house_address }}" class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 80px; height: 60px;">
                                                        <i class="fas fa-home fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $property->house_address }}</h6>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-door-open me-1"></i> {{ $property->house_number_room }} {{ Str::plural('room', $property->house_number_room) }}
                                                <i class="fas fa-toilet ms-2 me-1"></i> {{ $property->house_number_toilet }} {{ Str::plural('toilet', $property->house_number_toilet) }}
                                            </p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="badge {{ $property->approvedTenants->count() > 0 ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $property->approvedTenants->count() > 0 ? 'Occupied' : 'Vacant' }}
                                            </span>
                                            <div class="mt-2">
                                                <a href="{{ route('landlord.properties.show', $property->houseID) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($propertiesCount > 3)
                            <div class="text-center mt-3">
                                <a href="{{ route('landlord.properties.index') }}" class="btn btn-link text-primary">
                                    View all {{ $propertiesCount }} properties <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-building"></i>
                            </div>
                            <h5>No Properties Yet</h5>
                            <p class="text-muted">Add your first property to get started</p>
                            <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i>Add Property
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Maintenance Reports -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Maintenance Reports</h5>
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentReports->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentReports as $report)
                                <div class="list-group-item px-0 py-3 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="status-indicator 
                                                @if($report->report_status == 'Pending') bg-warning 
                                                @elseif($report->report_status == 'In Progress') bg-info 
                                                @elseif($report->report_status == 'Completed') bg-success 
                                                @else bg-danger @endif">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0">{{ $report->item->item_name }} Issue</h6>
                                                <span class="badge 
                                                    @if($report->report_status == 'Pending') bg-warning 
                                                    @elseif($report->report_status == 'In Progress') bg-info 
                                                    @elseif($report->report_status == 'Completed') bg-success 
                                                    @else bg-danger @endif">
                                                    {{ $report->report_status }}
                                                </span>
                                            </div>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-home me-1"></i> {{ $report->room->house->house_address }} -
                                                <i class="fas fa-door-open me-1"></i> {{ $report->room->room_type }}
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-user me-1"></i> Reported by {{ $report->user->name }} - 
                                                <i class="fas fa-clock me-1"></i> {{ $report->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h5>No Maintenance Reports</h5>
                            <p class="text-muted">You don't have any maintenance reports yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contractors Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Contractors</h5>
                    <a href="{{ route('landlord.contractors.index') }}" class="btn btn-sm btn-outline-primary">Manage Contractors</a>
                </div>
                <div class="card-body">
                    @if($approvedContractors->count() > 0)
                        <div class="row">
                            @foreach($approvedContractors as $contractor)
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
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
                                                    <div class="text-muted me-2">Specialization:</div>
                                                    <div><span class="badge bg-primary rounded-pill">{{ $contractor->pivot->specialization }}</span></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('landlord.contractors.show', $contractor->userID) }}" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(count($approvedContractors) < 3 && $pendingContractorCount == 0)
                            <div class="text-center mt-3">
                                <a href="{{ route('landlord.contractors.index') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Find More Contractors
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-hard-hat"></i>
                            </div>
                            <h5>No Contractors Yet</h5>
                            <p class="text-muted">You don't have any approved contractors yet</p>
                            <a href="{{ route('landlord.contractors.index') }}" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i>Find Contractors
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome and custom styles -->
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .card {
        transition: transform 0.2s;
        border-radius: 0.75rem;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-primary {
        background-color: #0ea5e9;
        border-color: #0ea5e9;
    }
    .btn-primary:hover {
        background-color: #0284c7;
        border-color: #0284c7;
    }
    .text-primary {
        color: #0ea5e9 !important;
    }
    .bg-primary {
        background-color: #0ea5e9 !important;
    }
    .alert-info {
        background-color: #f0f9ff;
        border-color: #e0f2fe;
        color: #0369a1;
    }
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .bg-primary-light {
        background-color: rgba(14, 165, 233, 0.1);
    }
    .bg-success-light {
        background-color: rgba(34, 197, 94, 0.1);
    }
    .bg-warning-light {
        background-color: rgba(245, 158, 11, 0.1);
    }
    .bg-info-light {
        background-color: rgba(6, 182, 212, 0.1);
    }
    .text-success {
        color: #22c55e !important;
    }
    .text-warning {
        color: #f59e0b !important;
    }
    .text-info {
        color: #06b6d4 !important;
    }
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
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
    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }
</style>
@endpush
@endsection