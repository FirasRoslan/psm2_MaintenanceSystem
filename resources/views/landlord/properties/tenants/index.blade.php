@extends('ui.layout')

@section('title', 'Tenant Management')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header Section - Kept the same as requested -->
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

    <!-- Tenants List Card -->
    <div class="card border-0 shadow-sm tenant-list-card">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Your Tenants</h5>
                </div>
                <div class="search-filter">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="tenantSearch" class="form-control border-0 bg-light" placeholder="Search tenants...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($tenants->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 tenant-table">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Tenant</th>
                                <th>Contact Information</th>
                                <th>Assigned Property</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenants as $tenant)
                                <tr class="tenant-row fade-in">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="tenant-avatar me-3">
                                                <span class="avatar-initials">{{ substr($tenant->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $tenant->name }}</h6>
                                                <span class="tenant-id text-muted">ID: {{ $tenant->userID }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                <span>{{ $tenant->email }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-phone text-primary me-2"></i>
                                                <span>{{ $tenant->phone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($tenant->tenantHouses->count() > 0)
                                            @php
                                                $house = $tenant->tenantHouses->first();
                                                $pivotStatus = $house->pivot->approval_status;
                                                $statusText = $pivotStatus === true ? 'Approved' : ($pivotStatus === false ? 'Rejected' : 'Pending');
                                                $statusColor = $pivotStatus === true ? 'success' : ($pivotStatus === false ? 'danger' : 'warning');
                                            @endphp
                                            <div class="property-info d-flex align-items-center">
                                                <div class="property-image-small me-3">
                                                    <img src="{{ asset('storage/' . $house->house_image) }}" alt="Property" class="property-thumbnail">
                                                </div>
                                                <div>
                                                    <p class="property-address mb-0">{{ $house->house_address }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="no-property d-flex align-items-center">
                                                <i class="fas fa-home text-muted me-2"></i>
                                                <span class="text-muted">No property assigned</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge bg-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}-subtle text-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }}">
                                            <i class="fas fa-{{ $tenant->approval_status == 'active' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                            {{ ucfirst($tenant->approval_status) }}
                                        </span>
                                        
                                        @if($tenant->tenantHouses->count() > 0)
                                            @php
                                                $house = $tenant->tenantHouses->first();
                                                $pivotStatus = $house->pivot->approval_status;
                                                $statusText = $pivotStatus === true ? 'Approved' : ($pivotStatus === false ? 'Rejected' : 'Pending');
                                                $statusColor = $pivotStatus === true ? 'success' : ($pivotStatus === false ? 'danger' : 'warning');
                                            @endphp
                                            <span class="assignment-status d-block mt-2 bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                                <i class="fas fa-{{ $statusColor == 'success' ? 'check-circle' : ($statusColor == 'danger' ? 'times-circle' : 'clock') }} me-1"></i>
                                                {{ $statusText }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="action-buttons">
                                            <a href="{{ route('landlord.tenants.show', $tenant->userID) }}" 
                                               class="btn btn-sm btn-outline-primary me-2" 
                                               data-bs-toggle="tooltip" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" 
                                               class="btn btn-sm btn-outline-secondary me-2"
                                               data-bs-toggle="tooltip" 
                                               title="Edit Tenant">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDelete({{ $tenant->userID }})"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Tenant">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
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
            @endif
        </div>
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
/* Keep existing styles for page header, buttons, etc. */
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

/* New styles for tenant list view */
.tenant-list-card {
    border-radius: 16px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.search-filter .input-group {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.search-filter .form-control:focus {
    box-shadow: none;
}

.tenant-table thead th {
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.tenant-row {
    transition: all 0.3s ease;
}

.tenant-row:hover {
    background-color: rgba(99, 102, 241, 0.03);
}

.tenant-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
}

.tenant-id {
    font-size: 0.75rem;
}

.contact-info {
    font-size: 0.875rem;
}

.property-image-small {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    overflow: hidden;
}

.property-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-address {
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
}

.assignment-status {
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.action-buttons .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
}

.no-property {
    font-size: 0.875rem;
}

/* Empty state styles - keep existing */
.empty-state {
    padding: 4rem 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
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

/* Responsive styles */
@media (max-width: 992px) {
    .search-filter {
        margin-top: 1rem;
    }
    
    .card-header {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
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
    
    .tenant-table {
        min-width: 900px;
    }
}
</style>

@push('scripts')
<script>
// Keep existing delete confirmation script
function confirmDelete(tenantId) {
    const form = document.getElementById('deleteForm');
    form.action = `/tenants/${tenantId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Add search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tenantSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.tenant-row');
            
            rows.forEach(row => {
                const tenantName = row.querySelector('.fw-semibold').textContent.toLowerCase();
                const tenantEmail = row.querySelector('.contact-info span').textContent.toLowerCase();
                const tenantPhone = row.querySelectorAll('.contact-info span')[1].textContent.toLowerCase();
                
                if (tenantName.includes(searchTerm) || tenantEmail.includes(searchTerm) || tenantPhone.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection