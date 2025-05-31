@extends('ui.layout')

@section('title', 'My Requests')

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
                                <a href="{{ route('contractor.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">My Requests</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-clipboard-list me-3"></i>My Requests
                    </h1>
                    <p class="page-subtitle mb-0">View and manage your landlord approval requests</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('contractor.find-landlords') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Find Landlords
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Status Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="summary-card pending">
                <div class="summary-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-content">
                    <h3 class="summary-number">{{ $pendingRequests->count() }}</h3>
                    <p class="summary-label">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card approved">
                <div class="summary-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-content">
                    <h3 class="summary-number">{{ $approvedRequests->count() }}</h3>
                    <p class="summary-label">Approved</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card rejected">
                <div class="summary-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="summary-content">
                    <h3 class="summary-number">{{ $rejectedRequests->count() }}</h3>
                    <p class="summary-label">Rejected</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card total">
                <div class="summary-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="summary-content">
                    <h3 class="summary-number">{{ $allRequests->count() }}</h3>
                    <p class="summary-label">Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-section mb-4">
        <div class="filter-header">
            <h5 class="filter-title">
                <i class="fas fa-filter me-2"></i>Filter by Status
            </h5>
        </div>
        <div class="filter-buttons">
            <div class="btn-group" role="group" id="statusFilters">
                <input type="radio" class="btn-check" name="status" id="all" value="all" checked>
                <label class="btn btn-filter" for="all">
                    <i class="fas fa-list me-1"></i>All ({{ $allRequests->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="pending" value="pending">
                <label class="btn btn-filter" for="pending">
                    <i class="fas fa-clock me-1"></i>Pending ({{ $pendingRequests->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="approved" value="approved">
                <label class="btn btn-filter" for="approved">
                    <i class="fas fa-check-circle me-1"></i>Approved ({{ $approvedRequests->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="rejected" value="rejected">
                <label class="btn btn-filter" for="rejected">
                    <i class="fas fa-times-circle me-1"></i>Rejected ({{ $rejectedRequests->count() }})
                </label>
            </div>
        </div>
    </div>

    <!-- Requests Grid -->
    @if($allRequests->count() > 0)
    <div class="requests-grid">
        @foreach($allRequests as $request)
        <div class="request-card fade-in request-item" 
             data-status="@if(is_null($request->approval_status))pending @elseif($request->approval_status == 1)approved @else rejected @endif">
            <div class="request-header">
                <div class="request-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="request-title-section">
                    <h5 class="request-title">{{ $request->landlord->name }}</h5>
                    <span class="request-date">{{ $request->created_at->format('M d, Y') }}</span>
                </div>
                <span class="status-badge 
                    @if(is_null($request->approval_status)) pending
                    @elseif($request->approval_status == 1) approved
                    @else rejected
                    @endif">
                    @if(is_null($request->approval_status))
                        Pending
                    @elseif($request->approval_status == 1)
                        Approved
                    @else
                        Rejected
                    @endif
                </span>
            </div>
            
            <div class="request-content">
                <!-- Landlord Info -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Landlord Email</span>
                        <span class="info-value">{{ $request->landlord->email }}</span>
                    </div>
                </div>

                <!-- Specializations -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Specializations</span>
                        <div class="specializations-tags mt-1">
                            @foreach(explode(', ', $request->specialization) as $spec)
                                <span class="specialization-tag">{{ $spec }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Maintenance Scope -->
                <div class="description-box mb-3">
                    <h6 class="mb-2">Maintenance Scope</h6>
                    <p class="mb-0">{{ Str::limit($request->maintenance_scope, 150) }}</p>
                </div>

                <!-- Request Date -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Submitted</span>
                        <span class="info-value">{{ $request->created_at->format('M d, Y \\a\\t g:i A') }}</span>
                    </div>
                </div>

                @if($request->updated_at != $request->created_at)
                <!-- Last Updated -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $request->updated_at->format('M d, Y \\a\\t g:i A') }}</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="request-actions">
                @if($request->approval_status == 1)
                    <a href="{{ route('contractor.landlord-profile', $request->landlord->userID) }}" 
                       class="btn btn-request-action">
                        <i class="fas fa-user me-2"></i>View Profile
                    </a>
                    <a href="{{ route('contractor.tasks') }}" 
                       class="btn btn-request-action-secondary mt-2">
                        <i class="fas fa-tasks me-2"></i>View Tasks
                    </a>
                @elseif(is_null($request->approval_status))
                    <button class="btn btn-request-action" disabled>
                        <i class="fas fa-hourglass-half me-2"></i>Awaiting Response
                    </button>
                @else
                    <a href="{{ route('contractor.find-landlords') }}" 
                       class="btn btn-request-action">
                        <i class="fas fa-search me-2"></i>Find Other Landlords
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="empty-title">No Requests Found</h3>
        <p class="empty-description">You haven't sent any requests to landlords yet.</p>
        <a href="{{ route('contractor.find-landlords') }}" class="btn btn-modern-primary">
            <i class="fas fa-search me-2"></i>Find Landlords
        </a>
    </div>
    @endif
</div>

<style>
/* Page Header Styles */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 0.5rem 1rem;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

/* Summary Cards */
.summary-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.summary-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.summary-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.summary-card.pending .summary-icon {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #d68910;
}

.summary-card.approved .summary-icon {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #27ae60;
}

.summary-card.rejected .summary-icon {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #e74c3c;
}

.summary-card.total .summary-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.summary-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #2c3e50;
}

.summary-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin: 0;
    font-weight: 500;
}

/* Filter Section */
.filter-section {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
}

.filter-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0 0 1rem 0;
}

.btn-filter {
    border: 2px solid #e9ecef;
    background: white;
    color: #6c757d;
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    border-color: #667eea;
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.btn-check:checked + .btn-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

/* Requests Grid */
.requests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
}

.request-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    opacity: 1;
}

.request-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.request-card.hidden {
    display: none;
}

.request-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.request-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.request-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.request-date {
    font-size: 0.85rem;
    color: #7f8c8d;
}

.request-title-section {
    flex: 1;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.1);
    color: #d68910;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.status-badge.approved {
    background: rgba(40, 167, 69, 0.1);
    color: #27ae60;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-badge.rejected {
    background: rgba(220, 53, 69, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

/* Info Items */
.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-icon {
    width: 35px;
    height: 35px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 0.9rem;
}

.info-content {
    flex: 1;
}

.info-label {
    display: block;
    font-size: 0.8rem;
    color: #7f8c8d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    display: block;
    font-size: 0.95rem;
    color: #2c3e50;
    font-weight: 600;
}

/* Specializations */
.specializations-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.specialization-tag {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Description Box */
.description-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    border-left: 4px solid #667eea;
}

.description-box h6 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.description-box p {
    color: #5a6c7d;
    line-height: 1.6;
}

/* Action Buttons */
.request-actions {
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.btn-request-action {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.btn-request-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-request-action:disabled {
    background: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-request-action-secondary {
    background: white;
    border: 2px solid #667eea;
    color: #667eea;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.btn-request-action-secondary:hover {
    background: #667eea;
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    font-size: 4rem;
    color: #e9ecef;
    margin-bottom: 1.5rem;
}

.empty-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
}

.empty-description {
    color: #7f8c8d;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

/* Modern Button Styles */
.btn-modern-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .requests-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .filter-buttons .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-filter {
        margin-bottom: 0.5rem;
    }
}

/* Animation */
.fade-in {
    animation: fadeIn 0.5s ease-in;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('input[name="status"]');
    const requestItems = document.querySelectorAll('.request-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('change', function() {
            const selectedStatus = this.value;
            
            requestItems.forEach(item => {
                if (selectedStatus === 'all') {
                    item.style.display = 'block';
                    item.classList.remove('hidden');
                } else {
                    const itemStatus = item.getAttribute('data-status');
                    if (itemStatus === selectedStatus) {
                        item.style.display = 'block';
                        item.classList.remove('hidden');
                    } else {
                        item.style.display = 'none';
                        item.classList.add('hidden');
                    }
                }
            });
        });
    });
});
</script>
@endsection