@extends('ui.layout')
@section('title', 'Landlord Dashboard')

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
                    <button class="btn btn-modern-primary" onclick="refreshDashboard()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh Dashboard
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Welcome Alert -->
        <div class="welcome-alert mt-4">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="alert-text">
                    <h6 class="mb-1">Welcome to your Property Management Dashboard</h6>
                    <p class="mb-0">Efficiently manage your properties, tenants, and maintenance requests all in one place.</p>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Notifications -->
        @if($pendingRequestsCount > 0)
        <div class="notification-card tenant-notification mt-3">
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="notification-text">
                    <h6 class="notification-title">Pending Tenant Requests</h6>
                    <p class="notification-desc">{{ $pendingRequestsCount }} tenant house assignment {{ Str::plural('request', $pendingRequestsCount) }} awaiting your review.</p>
                    <a href="{{ route('landlord.tenants.index') }}" class="btn btn-notification">
                        <i class="fas fa-users me-1"></i> Review Requests
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        @if($pendingContractorCount > 0)
        <div class="notification-card contractor-notification mt-3">
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <div class="notification-text">
                    <h6 class="notification-title">Pending Contractor Requests</h6>
                    <p class="notification-desc">{{ $pendingContractorCount }} contractor {{ Str::plural('request', $pendingContractorCount) }} awaiting approval.</p>
                    <a href="{{ route('landlord.contractors.index') }}" class="btn btn-notification">
                        <i class="fas fa-hard-hat me-1"></i> Review Applications
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        @if($pendingMaintenanceCount > 0)
        <div class="notification-card maintenance-notification mt-3">
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="notification-text">
                    <h6 class="notification-title">New Maintenance Reports</h6>
                    <p class="notification-desc">{{ $pendingMaintenanceCount }} maintenance {{ Str::plural('report', $pendingMaintenanceCount) }} submitted by tenants awaiting your attention.</p>
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-notification">
                        <i class="fas fa-tools me-1"></i> View Reports
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
            <p class="section-subtitle">Key metrics at a glance</p>
        </div>
        
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="modern-stat-card properties-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $propertiesCount }}</div>
                            <div class="stat-label">Total Properties</div>
                            <div class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> Active
                            </div>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="{{ route('landlord.properties.index') }}" class="stat-link">
                            View Properties <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="modern-stat-card rooms-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $totalRooms }}</div>
                            <div class="stat-label">Total Rooms</div>
                            <div class="stat-trend neutral">
                                <i class="fas fa-minus"></i> Available
                            </div>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <span class="stat-link">Room Management</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="modern-stat-card toilets-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-toilet"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $totalToilets }}</div>
                            <div class="stat-label">Total Toilets</div>
                            <div class="stat-trend neutral">
                                <i class="fas fa-check-circle"></i> Functional
                            </div>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <span class="stat-link">Facility Status</span>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="modern-stat-card tenants-card">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $approvedTenantsCount }}</div>
                            <div class="stat-label">Active Tenants</div>
                            <div class="stat-trend positive">
                                <i class="fas fa-user-check"></i> Approved
                            </div>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <a href="{{ route('landlord.tenants.index') }}" class="stat-link">
                            Manage Tenants <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts and Analytics Section -->
    <div class="analytics-section mb-5">
        <div class="row g-4">
            <!-- Maintenance Overview Chart -->
            <div class="col-lg-8">
                <div class="modern-card analytics-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Maintenance Analytics</h4>
                                <p class="card-subtitle mb-0">Track maintenance request trends</p>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-calendar me-1"></i> This Month
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Quarter</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="metric-box pending-metric">
                                    <div class="metric-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="metric-content">
                                        <div class="metric-number">{{ $pendingMaintenanceCount }}</div>
                                        <div class="metric-label">Pending</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="metric-box progress-metric">
                                    <div class="metric-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="metric-content">
                                        <div class="metric-number">{{ $inProgressMaintenanceCount }}</div>
                                        <div class="metric-label">In Progress</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="metric-box completed-metric">
                                    <div class="metric-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="metric-content">
                                        <div class="metric-number">{{ $completedMaintenanceCount }}</div>
                                        <div class="metric-label">Completed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Placeholder for future line chart -->
                        <div class="chart-placeholder">
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Maintenance Trends Chart</h6>
                                <p class="text-muted small">Coming Soon - Historical maintenance data visualization</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Pie Chart -->
            <div class="col-lg-4">
                <div class="modern-card chart-card">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Status Distribution</h4>
                        <p class="card-subtitle mb-0">Current maintenance breakdown</p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="maintenanceChart"></canvas>
                        </div>
                        <div class="chart-legend mt-3">
                            <div class="legend-item">
                                <span class="legend-color pending"></span>
                                <span class="legend-text">Pending ({{ $pendingMaintenanceCount }})</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color progress"></span>
                                <span class="legend-text">In Progress ({{ $inProgressMaintenanceCount }})</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color completed"></span>
                                <span class="legend-text">Completed ({{ $completedMaintenanceCount }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Activities Section -->
    <div class="activities-section">
        <div class="row g-4">
            <!-- Recent Properties -->
            <div class="col-lg-6">
                <div class="modern-card activity-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Your Properties</h4>
                                <p class="card-subtitle mb-0">Recently added properties</p>
                            </div>
                            <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-right me-1"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentProperties->count() > 0)
                            <div class="activity-list">
                                @foreach($recentProperties as $property)
                                    <div class="activity-item property-item">
                                        <div class="activity-image">
                                            @if($property->house_image)
                                                <img src="{{ asset('storage/' . $property->house_image) }}" alt="{{ $property->house_address }}" class="property-thumbnail">
                                            @else
                                                <div class="property-placeholder">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="activity-content">
                                            <h6 class="activity-title">{{ $property->house_address }}</h6>
                                            <div class="activity-meta">
                                                <span class="meta-item">
                                                    <i class="fas fa-door-open"></i> {{ $property->house_number_room }} {{ Str::plural('room', $property->house_number_room) }}
                                                </span>
                                                <span class="meta-item">
                                                    <i class="fas fa-toilet"></i> {{ $property->house_number_toilet }} {{ Str::plural('toilet', $property->house_number_toilet) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="activity-actions">
                                            <span class="status-badge {{ $property->approvedTenants->count() > 0 ? 'occupied' : 'vacant' }}">
                                                {{ $property->approvedTenants->count() > 0 ? 'Occupied' : 'Vacant' }}
                                            </span>
                                            <a href="{{ route('landlord.properties.show', $property->houseID) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h6 class="empty-title">No Properties Yet</h6>
                                <p class="empty-text">Add your first property to get started with property management</p>
                                <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add First Property
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Maintenance Reports -->
            <div class="col-lg-6">
                <div class="modern-card activity-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Recent Maintenance</h4>
                                <p class="card-subtitle mb-0">Latest maintenance requests</p>
                            </div>
                            <a href="{{ route('landlord.requests.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-right me-1"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentReports->count() > 0)
                            <div class="activity-list">
                                @foreach($recentReports as $report)
                                    <div class="activity-item maintenance-item">
                                        <div class="activity-status">
                                            <div class="status-indicator {{ strtolower(str_replace(' ', '-', $report->report_status)) }}"></div>
                                        </div>
                                        <div class="activity-content">
                                            <h6 class="activity-title">{{ $report->item->item_name }}</h6>
                                            <div class="activity-meta">
                                                <span class="meta-item">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $report->room->house->house_address }}
                                                </span>
                                                <span class="meta-item">
                                                    <i class="fas fa-door-closed"></i> {{ $report->room->room_type }}
                                                </span>
                                            </div>
                                            <div class="activity-time">
                                                <i class="fas fa-clock"></i> {{ $report->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <div class="activity-actions">
                                            <span class="status-badge {{ strtolower(str_replace(' ', '-', $report->report_status)) }}">
                                                {{ $report->report_status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <h6 class="empty-title">No Recent Reports</h6>
                                <p class="empty-text">Maintenance reports will appear here when submitted by tenants</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 20px;
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.tenant-notification {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.contractor-notification {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.maintenance-notification {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.notification-content {
    display: flex;
    align-items: center;
}

.notification-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 24px;
}

.tenant-notification .notification-icon {
    background: rgba(255, 255, 255, 0.2);
}

.contractor-notification .notification-icon {
    background: rgba(255, 255, 255, 0.2);
}

.maintenance-notification .notification-icon {
    background: rgba(255, 255, 255, 0.2);
}

.maintenance-notification .notification-icon {
    background: rgba(255, 255, 255, 0.2);
}

.notification-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.notification-desc {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 15px;
}

.btn-notification {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    transition: all 0.3s ease;
}

.btn-notification:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
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
    margin: 0;
}

/* Modern Stat Cards */
.modern-stat-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
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
    overflow: hidden;
}

.properties-card .stat-card-body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.rooms-card .stat-card-body {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.toilets-card .stat-card-body {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.tenants-card .stat-card-body {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1.5rem;
    font-size: 1.75rem;
    backdrop-filter: blur(10px);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.95rem;
    opacity: 0.9;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-trend {
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    opacity: 0.8;
}

.stat-trend i {
    margin-right: 0.25rem;
    font-size: 0.75rem;
}

.stat-card-footer {
    padding: 1rem 2rem;
    background: rgba(0, 0, 0, 0.02);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-link {
    color: #6b7280;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.stat-link:hover {
    color: #374151;
}

/* Modern Cards */
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.modern-card .card-header {
    background: white;
    border-bottom: 1px solid #f1f5f9;
    padding: 2rem 2rem 1rem;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.card-subtitle {
    color: #6b7280;
    font-size: 0.95rem;
    margin: 0;
}

.modern-card .card-body {
    padding: 1rem 2rem 2rem;
}

/* Metric Boxes */
.metric-box {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.metric-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.pending-metric {
    border-left: 4px solid #f59e0b;
}

.progress-metric {
    border-left: 4px solid #3b82f6;
}

.completed-metric {
    border-left: 4px solid #10b981;
}

.metric-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.25rem;
}

.pending-metric .metric-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.progress-metric .metric-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.completed-metric .metric-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.metric-number {
    font-size: 2rem;
    font-weight: 800;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.metric-label {
    color: #6b7280;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Chart Styles */
.chart-container {
    position: relative;
    height: 250px;
    margin-bottom: 1rem;
}

.chart-legend {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.legend-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
    margin-right: 0.75rem;
}

.legend-color.pending {
    background: #f59e0b;
}

.legend-color.progress {
    background: #3b82f6;
}

.legend-color.completed {
    background: #10b981;
}

.legend-text {
    color: #374151;
    font-weight: 500;
}

/* Activity Lists */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    transform: translateX(4px);
}

/* Property Items */
.property-item .activity-image {
    margin-right: 1rem;
}

.property-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    object-fit: cover;
}

.property-placeholder {
    width: 60px;
    height: 60px;
    background: #e2e8f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 1.5rem;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.activity-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.25rem;
}

.meta-item {
    color: #6b7280;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.meta-item i {
    margin-right: 0.25rem;
    font-size: 0.75rem;
}

.activity-time {
    color: #9ca3af;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
}

.activity-time i {
    margin-right: 0.25rem;
}

.activity-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Status Badges */
.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.status-badge.occupied {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-badge.vacant {
    background: rgba(107, 114, 128, 0.1);
    color: #374151;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-badge.in-progress {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.status-badge.completed {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

/* Maintenance Items */
.maintenance-item .activity-status {
    margin-right: 1rem;
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-indicator.pending {
    background: #f59e0b;
}

.status-indicator.in-progress {
    background: #3b82f6;
}

.status-indicator.completed {
    background: #10b981;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #94a3b8;
    font-size: 2rem;
}

.empty-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #6b7280;
    margin-bottom: 1.5rem;
    max-width: 300px;
    margin-left: auto;
    margin-right: auto;
}

/* Chart Placeholder */
.chart-placeholder {
    background: #f8fafc;
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
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
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .modern-card .card-header,
    .modern-card .card-body {
        padding: 1.5rem;
    }
    
    .activity-meta {
        flex-direction: column;
        gap: 0.25rem;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.6s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #6366f1;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
// Enhanced Maintenance Status Pie Chart
const ctx = document.getElementById('maintenanceChart').getContext('2d');
const maintenanceChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            data: [{{ $pendingMaintenanceCount }}, {{ $inProgressMaintenanceCount }}, {{ $completedMaintenanceCount }}],
            backgroundColor: [
                '#f59e0b',
                '#3b82f6',
                '#10b981'
            ],
            borderWidth: 0,
            cutout: '75%',
            borderRadius: 8,
            spacing: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                borderColor: 'rgba(255, 255, 255, 0.1)',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        },
        animation: {
            animateRotate: true,
            duration: 1000
        }
    }
});

// Enhanced Refresh Dashboard Function
function refreshDashboard() {
    const button = document.querySelector('.btn-modern-primary');
    const icon = button.querySelector('i');
    
    // Add loading state
    button.disabled = true;
    icon.classList.add('fa-spin');
    
    // Simulate refresh (replace with actual refresh logic)
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Add fade-in animation to cards on load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.modern-stat-card, .modern-card, .notification-card');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('fade-in');
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    cards.forEach(card => {
        observer.observe(card);
    });
    
    // Add hover effects to interactive elements
    const interactiveElements = document.querySelectorAll('.activity-item, .metric-box');
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Real-time updates simulation (replace with actual WebSocket or polling)
function simulateRealTimeUpdates() {
    // This would typically connect to a WebSocket or use polling
    // to update dashboard data in real-time
    console.log('Real-time updates would be implemented here');
}

// Initialize real-time updates
// simulateRealTimeUpdates();
</script>
@endpush
@endsection