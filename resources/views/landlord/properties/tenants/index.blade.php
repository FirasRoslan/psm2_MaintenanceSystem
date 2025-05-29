@extends('ui.layout')

@section('title', 'Tenant Management')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="page-title-section">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('landlord.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Tenants</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-users me-3"></i>Tenant Management
                    </h1>
                    <p class="page-subtitle mb-0">Manage your property tenant assignments and relationships</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('landlord.tenants.create') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Add New Tenant
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg text-success"></i>
            </div>
            <div class="flex-grow-1">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tenants Grid -->
    <div class="tenants-grid">
        @forelse($tenants as $tenant)
            <div class="tenant-card fade-in">
                <div class="tenant-header">
                    <div class="tenant-avatar-container">
                        <div class="tenant-avatar">
                            <span class="avatar-initials">{{ substr($tenant->name, 0, 1) }}</span>
                        </div>
                        <div class="tenant-status">
                            <span class="status-badge bg-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $tenant->approval_status == 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                {{ ucfirst($tenant->approval_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="tenant-content">
                    <div class="tenant-info">
                        <h5 class="tenant-name">{{ $tenant->name }}</h5>
                        <div class="contact-details">
                            <div class="contact-item">
                                <i class="fas fa-envelope me-2"></i>
                                <span>{{ $tenant->email }}</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone me-2"></i>
                                <span>{{ $tenant->phone }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Property Assignment Preview -->
                    <div class="property-assignment">
                        <h6 class="assignment-title">Assigned Property</h6>
                        @if($tenant->tenantHouses->count() > 0)
                            @php
                                $house = $tenant->tenantHouses->first();
                                $pivotStatus = $house->pivot->approval_status;
                                $statusText = $pivotStatus === true ? 'Approved' : ($pivotStatus === false ? 'Rejected' : 'Pending');
                                $statusColor = $pivotStatus === true ? 'success' : ($pivotStatus === false ? 'danger' : 'warning');
                            @endphp
                            <div class="property-preview">
                                <div class="property-image-small">
                                    <img src="{{ asset('storage/' . $house->house_image) }}" alt="Property" class="property-thumbnail">
                                </div>
                                <div class="property-details">
                                    <p class="property-address">{{ $house->house_address }}</p>
                                    <span class="assignment-status bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                        <i class="fas fa-{{ $statusColor == 'success' ? 'check-circle' : ($statusColor == 'danger' ? 'times-circle' : 'clock') }} me-1"></i>
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="no-assignment">
                                <i class="fas fa-home text-muted"></i>
                                <span class="text-muted">No property assigned</span>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="tenant-actions">
                        <a href="{{ route('landlord.tenants.show', $tenant->userID) }}" 
                           class="btn btn-tenant-action">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                        <div class="action-buttons">
                            <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                    onclick="confirmDelete({{ $tenant->userID }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-content">
                    <div class="empty-state-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="empty-state-title">No Tenants Yet</h4>
                    <p class="empty-state-description">Start managing your tenants by adding your first tenant assignment.</p>
                    <a href="{{ route('landlord.tenants.create') }}" class="btn btn-modern-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Add Your First Tenant
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this tenant assignment? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--primary-dark);
}

.btn-modern-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: white;
}

.tenants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.tenant-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.tenant-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.tenant-header {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.tenant-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(30px, -30px);
}

.tenant-avatar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.tenant-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.avatar-initials {
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    border: 2px solid currentColor;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
}

.tenant-content {
    padding: 1.5rem;
}

.tenant-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.contact-details {
    margin-bottom: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.contact-item i {
    color: var(--primary-color);
    width: 16px;
}

.assignment-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.property-preview {
    display: flex;
    align-items: center;
    background: rgba(99, 102, 241, 0.05);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.property-image-small {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 1rem;
}

.property-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-details {
    flex: 1;
}

.property-address {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.assignment-status {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.no-assignment {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.no-assignment i {
    margin-right: 0.5rem;
    font-size: 1.2rem;
}

.tenant-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.btn-tenant-action {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    flex: 1;
    transition: all 0.3s ease;
}

.btn-tenant-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-buttons .btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.empty-state {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
}

.empty-state-content {
    text-align: center;
    max-width: 400px;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.empty-state-description {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .tenants-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .page-actions {
        margin-top: 1rem;
    }
    
    .page-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .tenant-actions {
        flex-direction: column;
    }
    
    .action-buttons {
        width: 100%;
        justify-content: center;
    }
}
</style>

@push('scripts')
<script>
function confirmDelete(tenantId) {
    const form = document.getElementById('deleteForm');
    form.action = `/tenants/${tenantId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
@endsection