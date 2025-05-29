@extends('ui.layout')

@section('title', 'Tenant Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.tenants.index') }}" class="text-decoration-none">Tenants</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $tenant->name }}</li>
            </ol>
        </nav>
        
        <div class="d-flex justify-content-between align-items-start">
            <div class="page-title-section">
                <div class="d-flex align-items-center mb-2">
                    <div class="page-icon me-3">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h1 class="page-title mb-0">Tenant House Assignment</h1>
                        <p class="page-subtitle mb-0">Manage and view tenant property assignments</p>
                    </div>
                </div>
            </div>
            
            <div class="page-actions d-flex gap-2">
                <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Assignment
                </a>
                <a href="{{ route('landlord.tenants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list me-2"></i>All Tenants
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Enhanced Tenant Information Card -->
        <div class="col-lg-4">
            <div class="glass-card h-100">
                <div class="card-body p-4 text-center">
                    <div class="tenant-avatar mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="initials">{{ substr($tenant->name, 0, 1) }}</span>
                        </div>
                        <div class="status-indicator">
                            <span class="badge status-badge bg-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $tenant->approval_status == 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                {{ ucfirst($tenant->approval_status) }}
                            </span>
                        </div>
                    </div>
                    
                    <h3 class="tenant-name mb-2">{{ $tenant->name }}</h3>
                    <p class="tenant-role mb-4">Property Tenant</p>
                    
                    <div class="tenant-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">Email Address</span>
                                <span class="detail-value">{{ $tenant->email }}</span>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">Phone Number</span>
                                <span class="detail-value">{{ $tenant->phone }}</span>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span class="detail-label">Member Since</span>
                                <span class="detail-value">{{ $tenant->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Property Assignments -->
        <div class="col-lg-8">
            <div class="glass-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h4 class="header-title mb-0">Property Assignments</h4>
                            <p class="header-subtitle mb-0">Current property assignments for this tenant</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if($houses->count() > 0)
                        <div class="assignments-grid">
                            @foreach($houses as $house)
                            @php
                                $pivotStatus = $house->pivot->approval_status;
                                $statusText = $pivotStatus === true ? 'Approved' : ($pivotStatus === false ? 'Rejected' : 'Pending');
                                $statusColor = $pivotStatus === true ? 'success' : ($pivotStatus === false ? 'danger' : 'warning');
                            @endphp
                            <div class="assignment-card">
                                <div class="assignment-content">
                                    <div class="property-preview">
                                        <img src="{{ asset('storage/' . $house->house_image) }}" 
                                             class="property-thumbnail" 
                                             alt="{{ $house->house_address }}">
                                        <div class="assignment-status">
                                            <span class="status-badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                                <i class="fas fa-{{ $statusColor == 'success' ? 'check-circle' : ($statusColor == 'danger' ? 'times-circle' : 'clock') }} me-1"></i>
                                                {{ $statusText }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="property-info">
                                        <h5 class="property-title">{{ $house->house_address }}</h5>
                                        
                                        <div class="property-meta">
                                            <div class="meta-item">
                                                <i class="fas fa-door-open"></i>
                                                <span>{{ $house->rooms->count() }} Rooms</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-user"></i>
                                                <span>Owner: {{ $house->user->name }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="fas fa-calendar"></i>
                                                <span>Assigned: {{ $house->pivot->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="assignment-actions">
                                        <a href="{{ route('landlord.properties.show', $house->houseID) }}" 
                                           class="btn btn-outline-primary btn-sm action-btn">
                                            <i class="fas fa-eye me-1"></i>View Property
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-container">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h4 class="empty-title">No Property Assigned</h4>
                                <p class="empty-description">This tenant hasn't been assigned to any property yet. Click the button below to assign a property.</p>
                                <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>Assign Property
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

.page-header {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 2rem;
}

.page-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-gradient);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--bs-dark);
    margin: 0;
}

.page-subtitle {
    color: var(--bs-secondary);
    font-size: 1rem;
    margin: 0;
}

.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.avatar-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2.5rem;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
    position: relative;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
    border: 2px solid currentColor;
}

.tenant-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--bs-dark);
    margin-bottom: 0.5rem;
}

.tenant-role {
    color: var(--bs-secondary);
    font-size: 1rem;
    font-weight: 500;
}

.tenant-details {
    text-align: left;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 16px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
}

.detail-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    font-size: 1.1rem;
}

.detail-content {
    flex: 1;
}

.detail-label {
    display: block;
    font-size: 0.875rem;
    color: var(--bs-secondary);
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.detail-value {
    display: block;
    font-size: 1rem;
    color: var(--bs-dark);
    font-weight: 600;
}

.card-header {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    padding: 1.5rem 2rem;
}

.header-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.header-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bs-dark);
}

.header-subtitle {
    color: var(--bs-secondary);
    font-size: 0.95rem;
}

.assignments-grid {
    display: grid;
    gap: 1.5rem;
}

.assignment-card {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 20px;
    border: 1px solid rgba(102, 126, 234, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.assignment-card:hover {
    border-color: rgba(102, 126, 234, 0.3);
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.assignment-content {
    display: grid;
    grid-template-columns: 200px 1fr auto;
    gap: 1.5rem;
    padding: 1.5rem;
    align-items: center;
}

.property-preview {
    position: relative;
}

.property-thumbnail {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.assignment-status {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
}

.property-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bs-dark);
    margin-bottom: 1rem;
}

.property-meta {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.meta-item {
    display: flex;
    align-items: center;
    color: var(--bs-secondary);
    font-size: 0.95rem;
}

.meta-item i {
    width: 20px;
    margin-right: 0.75rem;
    color: var(--bs-primary);
}

.assignment-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.empty-state-container {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state {
    max-width: 400px;
    margin: 0 auto;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 3rem;
    color: var(--bs-primary);
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--bs-dark);
    margin-bottom: 1rem;
}

.empty-description {
    color: var(--bs-secondary);
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.page-actions .btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.page-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--bs-primary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--bs-primary);
    opacity: 0.8;
}

.breadcrumb-item.active {
    color: var(--bs-secondary);
    font-weight: 600;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .assignment-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .property-meta {
        align-items: center;
    }
    
    .assignment-actions {
        flex-direction: row;
        justify-content: center;
    }
}
</style>
@endpush
@endsection