@extends('ui.layout')

@section('title', 'Landlord Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">Today, {{ now()->format('M d') }}</h4>
            <div class="alert alert-info">
                <i class="fas fa-bell me-2"></i> You have 0 reminders for Today · <a href="#" class="text-primary">View all</a>
            </div>
            
            <!-- Tenant request notification - moved inside the content section -->
            @if($pendingRequestsCount > 0)
            <div class="alert alert-warning border-0 shadow-sm mt-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-clock fa-2x text-warning me-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">Pending Tenant Requests</h5>
                        <p class="mb-2">You have {{ $pendingRequestsCount }} pending tenant house assignment request(s).</p>
                        <a href="{{ route('landlord.tenants.index') }}" class="btn btn-warning btn-sm px-4">
                            <i class="fas fa-users me-1"></i> View Requests
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5" style="background-color: #f0f9ff;">
                    <div class="mb-4">
                        <i class="fas fa-home fa-4x text-primary"></i>
                    </div>
                    <h4>Add a property</h4>
                    <p class="text-muted">Add your first property to get started</p>
                    <button class="btn btn-primary px-4">Get started</button>
                    <div class="text-muted mt-2">
                        <small><i class="fas fa-clock me-1"></i> Est. 2 min setup</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of the content remains unchanged -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recently viewed</h5>
                    <i class="fas fa-info-circle text-muted"></i>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <!-- Property items will go here -->
                        <div class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded" style="width: 80px; height: 60px;">
                                        <i class="fas fa-image fa-2x text-muted d-flex justify-content-center align-items-center h-100"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Sample Property</h6>
                                    <p class="text-muted small mb-0">123 Sample Street</p>
                                </div>
                                <span class="badge bg-success">Occupied</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Financial Overview</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Income</h6>
                        <h3 class="mb-0">$0.00</h3>
                    </div>
                    <div>
                        <h6 class="text-muted mb-2">Expenses</h6>
                        <h3 class="mb-0">$0.00</h3>
                    </div>
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
    .alert-info {
        background-color: #f0f9ff;
        border-color: #e0f2fe;
        color: #0369a1;
    }
    .alert-warning {
        background-color: #fffbeb;
        border-color: #fef3c7;
        color: #92400e;
    }
    .btn-warning {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }
    .btn-warning:hover {
        background-color: #d97706;
        border-color: #d97706;
        color: white;
    }
    .text-warning {
        color: #f59e0b !important;
    }
</style>
@endpush
@endsection