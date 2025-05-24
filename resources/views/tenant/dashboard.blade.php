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
            
            <!-- Property Status Summary -->
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-success-light me-3">
                                    <i class="fas fa-home text-success"></i>
                                </div>
                                <h5 class="mb-0">Approved Properties</h5>
                            </div>
                            <h2 class="mb-3">{{ $approvedHouses->count() }}</h2>
                            <p class="text-muted mb-0">Properties you have access to</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-warning-light me-3">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <h5 class="mb-0">Pending Requests</h5>
                            </div>
                            <h2 class="mb-3">{{ $pendingHouses->count() }}</h2>
                            <p class="text-muted mb-0">Properties awaiting landlord approval</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-info-light me-3">
                                    <i class="fas fa-tools text-info"></i>
                                </div>
                                <h5 class="mb-0">Maintenance Reports</h5>
                            </div>
                            <h2 class="mb-3">{{ $maintenanceReports->count() }}</h2>
                            <p class="text-muted mb-0">Active maintenance requests</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Quick Actions</h5>
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3 mb-md-0">
                                    <a href="{{ route('tenant.find-houses') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-search fa-2x mb-3 text-primary"></i>
                                        <span>Find Properties</span>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6 mb-3 mb-md-0">
                                    <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-home fa-2x mb-3 text-success"></i>
                                        <span>My Properties</span>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('tenant.reports.index') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-clipboard-list fa-2x mb-3 text-info"></i>
                                        <span>My Reports</span>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="#" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-user-cog fa-2x mb-3 text-secondary"></i>
                                        <span>My Profile</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- My Properties Section -->
            @if($approvedHouses->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="mb-0">My Properties</h5>
                            <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                @foreach($approvedHouses->take(3) as $house)
                                <div class="col-md-4 position-relative">
                                    <div class="property-card h-100 p-4 {{ !$loop->last ? 'border-end' : '' }}">
                                        <div class="d-flex mb-3">
                                            <div class="property-image me-3">
                                                <img src="{{ asset('storage/' . $house->house_image) }}" alt="Property" class="rounded-4" width="80" height="80" style="object-fit: cover;">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ \Illuminate\Support\Str::limit($house->house_address, 30) }}</h6>
                                                <p class="text-muted mb-0 small">{{ $house->rooms->count() }} rooms, {{ $house->house_number_toilet }} bathrooms</p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar-sm me-2 bg-primary text-white">
                                                    {{ substr($house->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="mb-0 small">Landlord: <strong>{{ $house->user->name }}</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('tenant.properties.show', $house->houseID) }}" class="btn btn-sm btn-primary rounded-pill w-100">
                                            <i class="fas fa-eye me-1"></i> View Details
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Recent Maintenance Reports -->
            @if($maintenanceReports->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="mb-0">Recent Maintenance Reports</h5>
                            <a href="{{ route('tenant.reports.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Property</th>
                                            <th>Item</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maintenanceReports->take(3) as $report)
                                        <tr>
                                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($report->room->house->house_address, 30) }}</td>
                                            <td>{{ $report->item->item_name }}</td>
                                            <td>
                                                @if($report->report_status == 'Pending')
                                                    <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                                @elseif($report->report_status == 'In Progress')
                                                    <span class="badge bg-info rounded-pill">In Progress</span>
                                                @elseif($report->report_status == 'Completed')
                                                    <span class="badge bg-success rounded-pill">Completed</span>
                                                @elseif($report->report_status == 'Rejected')
                                                    <span class="badge bg-danger rounded-pill">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('tenant.reports.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Pending Requests -->
            @if($pendingHouses->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center p-4">
                            <h5 class="mb-0">Pending Property Requests</h5>
                            <span class="badge bg-warning text-dark rounded-pill px-3">{{ $pendingHouses->count() }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($pendingHouses as $house)
                                <div class="list-group-item border-0 p-4">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <div class="d-flex align-items-center mb-3 mb-md-0">
                                            <div class="property-image me-3">
                                                <img src="{{ asset('storage/' . $house->house_image) }}" alt="Property" class="rounded-4" width="60" height="60" style="object-fit: cover;">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ \Illuminate\Support\Str::limit($house->house_address, 30) }}</h6>
                                                <p class="text-muted mb-0 small">Landlord: {{ $house->user->name }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-warning text-dark rounded-pill mb-2 mb-md-0 me-md-2">
                                                <i class="fas fa-clock me-1"></i> Awaiting Approval
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- No Properties Message -->
            @if($approvedHouses->count() == 0 && $pendingHouses->count() == 0)
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-5 text-center">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-home"></i>
                            </div>
                            <h5>No Properties Yet</h5>
                            <p class="text-muted mb-4">You haven't been assigned to any properties yet. Start by finding available properties.</p>
                            <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Find Properties
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
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
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1);
    }
    
    .property-card {
        transition: all 0.3s ease;
    }
    
    .property-card:hover {
        background-color: #f8f9fa;
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
</style>
@endpush
@endsection