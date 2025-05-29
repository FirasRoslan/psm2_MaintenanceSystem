@extends('ui.layout')

@section('title', 'Tenant Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Enhanced Header Section -->
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <h1 class="dashboard-title mb-2">
                        <span class="greeting-text">Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}!</span>
                        <span class="wave-emoji">👋</span>
                    </h1>
                    <p class="dashboard-subtitle mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="dashboard-actions">
                    <button class="btn btn-modern-primary" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh Dashboard
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Welcome Alert -->
        <div class="welcome-alert mt-4">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="alert-text">
                    <h6 class="mb-1">Welcome to your Tenant Dashboard</h6>
                    <p class="mb-0">Manage your rental properties, submit maintenance requests, and track your housing status all in one place.</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Notifications -->
        @if($pendingHouses->count() > 0)
        <div class="notification-card tenant-notification mt-3">
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="notification-text">
                    <h6 class="notification-title">Pending House Requests</h6>
                    <p class="notification-desc">{{ $pendingHouses->count() }} house assignment {{ Str::plural('request', $pendingHouses->count()) }} awaiting landlord approval.</p>
                    <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-notification">
                        <i class="fas fa-eye me-1"></i> View Requests
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        @if($maintenanceReports->count() > 0)
        <div class="notification-card contractor-notification mt-3">
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="notification-text">
                    <h6 class="notification-title">Active Maintenance Reports</h6>
                    <p class="notification-desc">{{ $maintenanceReports->count() }} maintenance {{ Str::plural('request', $maintenanceReports->count()) }} currently being processed.</p>
                    <a href="{{ route('tenant.reports.index') }}" class="btn btn-notification">
                        <i class="fas fa-clipboard-list me-1"></i> View Reports
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="stats-section mb-5">
        <div class="section-header mb-4">
            <h3 class="section-title">Property Overview</h3>
            <p class="section-subtitle">Your housing status at a glance</p>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="modern-stat-card properties-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $approvedHouses->count() }}</div>
                            <div class="stat-label">Approved Properties</div>
                            <div class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> Active
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="modern-stat-card tenants-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $pendingHouses->count() }}</div>
                            <div class="stat-label">Pending Requests</div>
                            <div class="stat-trend warning">
                                <i class="fas fa-hourglass-half"></i> Waiting
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="modern-stat-card reports-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $maintenanceReports->count() }}</div>
                            <div class="stat-label">Maintenance Reports</div>
                            <div class="stat-trend info">
                                <i class="fas fa-wrench"></i> Active
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Status Pie Chart -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('tenant.find-houses') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center hover-lift text-decoration-none">
                                <div class="icon-box bg-primary bg-opacity-10 p-3 rounded-3 mb-3">
                                    <i class="fas fa-search text-primary fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Find Properties</h6>
                                <p class="text-muted text-center mb-0 small">Discover available rental properties</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center hover-lift text-decoration-none">
                                <div class="icon-box bg-success bg-opacity-10 p-3 rounded-3 mb-3">
                                    <i class="fas fa-home text-success fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">My Properties</h6>
                                <p class="text-muted text-center mb-0 small">View your assigned properties</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('tenant.reports.create') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center hover-lift text-decoration-none">
                                <div class="icon-box bg-warning bg-opacity-10 p-3 rounded-3 mb-3">
                                    <i class="fas fa-plus-circle text-warning fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Submit Report</h6>
                                <p class="text-muted text-center mb-0 small">Report maintenance issues</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('tenant.reports.index') }}" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center hover-lift text-decoration-none">
                                <div class="icon-box bg-info bg-opacity-10 p-3 rounded-3 mb-3">
                                    <i class="fas fa-clipboard-list text-info fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">My Reports</h6>
                                <p class="text-muted text-center mb-0 small">Track maintenance requests</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="btn btn-light rounded-4 w-100 h-100 p-4 d-flex flex-column align-items-center justify-content-center hover-lift text-decoration-none">
                                <div class="icon-box bg-secondary bg-opacity-10 p-3 rounded-3 mb-3">
                                    <i class="fas fa-user text-secondary fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">My Profile</h6>
                                <p class="text-muted text-center mb-0 small">Update your information</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Property Status Overview</h5>
                    <div class="position-relative">
                        <canvas id="propertyStatusChart" width="300" height="300"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">Approved</span>
                            </div>
                            <span class="fw-bold">{{ $approvedHouses->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">Pending</span>
                            </div>
                            <span class="fw-bold">{{ $pendingHouses->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">Maintenance</span>
                            </div>
                            <span class="fw-bold">{{ $maintenanceReports->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Properties -->
    @if($approvedHouses->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">My Properties</h5>
                        <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-eye me-2"></i>View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        @foreach($approvedHouses->take(3) as $house)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $house->house_image) }}" class="card-img-top rounded-top-3" alt="{{ $house->house_address }}" style="height: 180px; object-fit: cover;">
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>Approved
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-2">{{ Str::limit($house->house_address, 30) }}</h6>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bed text-primary me-2"></i>
                                                <small class="text-muted">{{ $house->house_number_room }} rooms</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bath text-info me-2"></i>
                                                <small class="text-muted">{{ $house->house_number_toilet }} baths</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-user text-secondary me-2"></i>
                                        <small class="text-muted">{{ $house->user->name }}</small>
                                    </div>
                                    <a href="{{ route('tenant.properties.show', $house->houseID) }}" class="btn btn-primary btn-sm rounded-pill w-100">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
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
</div>

@push('styles')
<style>
/* Modern Dashboard Styles */
.dashboard-container {
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
}

/* Header Styles */
.dashboard-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.greeting-text {
    display: inline-block;
}

.wave-emoji {
    display: inline-block;
    animation: wave 2s infinite;
    transform-origin: 70% 70%;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-10deg); }
}

.dashboard-subtitle {
    color: #64748b;
    font-size: 1.1rem;
    font-weight: 500;
}

.btn-modern-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Welcome Alert */
.welcome-alert {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #c7d2fe;
}

.alert-content {
    display: flex;
    align-items: center;
}

.alert-icon {
    width: 48px;
    height: 48px;
    background: rgba(99, 102, 241, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #6366f1;
    font-size: 1.25rem;
}

.alert-text h6 {
    color: #3730a3;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-text p {
    color: #5b21b6;
    margin: 0;
}

/* Notification Cards */
.notification-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border-left: 4px solid;
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.tenant-notification {
    border-left-color: #f59e0b;
}

.contractor-notification {
    border-left-color: #3b82f6;
}

.notification-content {
    display: flex;
    align-items: center;
}

.notification-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
}

.tenant-notification .notification-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.contractor-notification .notification-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.notification-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.notification-desc {
    color: #6b7280;
    margin-bottom: 1rem;
}

.btn-notification {
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
    border: 1px solid rgba(99, 102, 241, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-notification:hover {
    background: #6366f1;
    color: white;
    border-color: #6366f1;
}

/* Stats Section */
.stats-section {
    margin-bottom: 3rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #6b7280;
    font-size: 1.1rem;
}

/* Modern Stat Cards */
.modern-stat-card {
    background: white;
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.stat-card-body {
    padding: 2rem;
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
}

.stat-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-right: 1.5rem;
    position: relative;
}

.properties-card .stat-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tenants-card .stat-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.reports-card .stat-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-trend {
    font-size: 0.875rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.stat-trend.positive {
    color: #10b981;
}

.stat-trend.warning {
    color: #f59e0b;
}

.stat-trend.info {
    color: #3b82f6;
}

.stat-trend i {
    margin-right: 0.25rem;
}

/* Hover Effects */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .stat-card-body {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
    }
    
    .stat-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Property Status Pie Chart
const ctx = document.getElementById('propertyStatusChart').getContext('2d');
const propertyStatusChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Approved', 'Pending', 'Maintenance'],
        datasets: [{
            data: [{{ $approvedHouses->count() }}, {{ $pendingHouses->count() }}, {{ $maintenanceReports->count() }}],
            backgroundColor: [
                '#198754',
                '#ffc107',
                '#0dcaf0'
            ],
            borderWidth: 0,
            cutout: '70%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

<style>
.hover-lift {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
}
</style>
@endsection