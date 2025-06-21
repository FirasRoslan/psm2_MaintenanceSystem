@extends('ui.layout')

@section('title', 'Manage Contractors')

@section('content')
<div class="container-fluid py-4">
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
                            <li class="breadcrumb-item active">Contractors</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-hard-hat me-3"></i>Manage Contractors
                    </h1>
                    <p class="page-subtitle mb-0">Approve or reject contractor requests and manage your contractors</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
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
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
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

    <!-- Contractors Grid -->
    <div class="row g-4">
        <!-- Pending Requests Section -->
        <div class="col-lg-6">
            <div class="contractors-section">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="section-icon me-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="section-title mb-0">Pending Requests</h4>
                                <p class="section-subtitle mb-0">Review and approve contractor applications</p>
                            </div>
                        </div>
                        @if($pendingRequests->count() > 0)
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ $pendingRequests->count() }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="contractors-grid">
                    @if($pendingRequests->count() > 0)
                        @foreach($pendingRequests as $contractor)
                        <div class="contractor-card pending">
                            <div class="contractor-header">
                                <div class="d-flex align-items-center">
                                    <div class="contractor-avatar pending">
                                        <span class="initials">{{ substr($contractor->name, 0, 1) }}</span>
                                    </div>
                                    <div class="contractor-info">
                                        <h5 class="contractor-name mb-1">{{ $contractor->name }}</h5>
                                        <p class="contractor-email mb-0">{{ $contractor->email }}</p>
                                        @if($contractor->phone)
                                        <p class="contractor-phone mb-0">{{ $contractor->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="status-badge">
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </div>
                            </div>
                            
                            <div class="contractor-details">
                                <div class="detail-item">
                                    <span class="detail-label">Scope:</span>
                                    <span class="detail-value">{{ $contractor->pivot->maintenance_scope }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Specialization:</span>
                                    <span class="badge bg-primary rounded-pill">{{ $contractor->pivot->specialization }}</span>
                                </div>
                            </div>
                            
                            <div class="contractor-actions">
                                <form action="{{ route('landlord.contractors.approve', $contractor->userID) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm me-2">
                                        <i class="fas fa-check me-1"></i>Approve
                                    </button>
                                </form>
                                <form action="{{ route('landlord.contractors.reject', $contractor->userID) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-times me-1"></i>Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <h5 class="empty-title">No Pending Requests</h5>
                            <p class="empty-description">You don't have any pending contractor requests at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Approved Contractors Section -->
        <div class="col-lg-6">
            <div class="contractors-section">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="section-icon me-3">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div>
                                <h4 class="section-title mb-0">Approved Contractors</h4>
                                <p class="section-subtitle mb-0">Manage your approved contractors</p>
                            </div>
                        </div>
                        @if($approvedContractors->count() > 0)
                        <span class="badge bg-success rounded-pill px-3 py-2">{{ $approvedContractors->count() }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="contractors-grid">
                    @if($approvedContractors->count() > 0)
                        @foreach($approvedContractors as $contractor)
                        <div class="contractor-card approved">
                            <div class="contractor-header">
                                <div class="d-flex align-items-center">
                                    <div class="contractor-avatar approved">
                                        <span class="initials">{{ substr($contractor->name, 0, 1) }}</span>
                                    </div>
                                    <div class="contractor-info">
                                        <h5 class="contractor-name mb-1">{{ $contractor->name }}</h5>
                                        <p class="contractor-email mb-0">{{ $contractor->email }}</p>
                                        @if($contractor->phone)
                                        <p class="contractor-phone mb-0">{{ $contractor->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="status-badge">
                                    <span class="badge bg-success">Approved</span>
                                </div>
                            </div>
                            
                            <div class="contractor-details">
                                <div class="detail-item">
                                    <span class="detail-label">Scope:</span>
                                    <span class="detail-value">{{ $contractor->pivot->maintenance_scope }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Specialization:</span>
                                    <span class="badge bg-primary rounded-pill">{{ $contractor->pivot->specialization }}</span>
                                </div>
                            </div>
                            
                            <div class="contractor-actions">
                                <a href="{{ route('landlord.contractors.show', $contractor->userID) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-user-hard-hat"></i>
                            </div>
                            <h5 class="empty-title">No Approved Contractors</h5>
                            <p class="empty-description">You don't have any approved contractors yet. Approve pending requests to get started.</p>
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
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --text-color: #1f2937;
        --text-muted: #6b7280;
        --border-color: #e5e7eb;
        --bg-light: #f8fafc;
    }

    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(99, 102, 241, 0.1);
    }
    
    .page-title-section .page-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .page-title-section .page-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin: 0;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .breadcrumb-item a:hover {
        color: var(--primary-dark);
    }
    
    .breadcrumb-item.active {
        color: var(--text-muted);
    }
    
    .page-actions .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        color: white;
    }
    
    /* Section Styling */
    .contractors-section {
        height: 100%;
    }
    
    .section-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .section-icon {
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
    
    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .section-subtitle {
        color: #64748b;
        font-size: 0.9rem;
    }
    
    /* Contractors Grid */
    .contractors-grid {
        background: white;
        border-radius: 0 0 15px 15px;
        min-height: 400px;
        max-height: 600px;
        overflow-y: auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .contractor-card {
        background: white;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .contractor-card:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }
    
    .contractor-card:last-child {
        border-bottom: none;
    }
    
    .contractor-card.pending {
        border-left: 4px solid #f59e0b;
    }
    
    .contractor-card.approved {
        border-left: 4px solid #10b981;
    }
    
    /* Contractor Avatar */
    .contractor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
        margin-right: 1rem;
    }
    
    .contractor-avatar.pending {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }
    
    .contractor-avatar.approved {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        color: white;
    }
    
    /* Contractor Info */
    .contractor-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .contractor-email {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .contractor-phone {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
    }
    
    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    
    /* Contractor Details */
    .contractor-details {
        margin: 1rem 0;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .detail-item:last-child {
        margin-bottom: 0;
    }
    
    .detail-label {
        font-weight: 500;
        color: #64748b;
        font-size: 0.9rem;
    }
    
    .detail-value {
        color: #1e293b;
        font-weight: 500;
    }
    
    /* Contractor Actions */
    .contractor-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #64748b;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: #94a3b8;
    }
    
    .empty-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    
    .empty-description {
        color: #64748b;
        margin: 0;
    }
    
    /* Button Styling */
    .btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-outline-primary {
        color: #667eea;
        border-color: #667eea;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .btn-outline-primary:hover {
        background: #667eea;
        border-color: #667eea;
        transform: translateY(-2px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transform: translateY(-2px);
    }
    
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-outline-danger:hover {
        background: #ef4444;
        border-color: #ef4444;
        transform: translateY(-2px);
    }
    
    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    .bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .contractor-card {
            padding: 1rem;
        }
        
        .contractor-actions {
            flex-direction: column;
        }
        
        .contractor-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .status-badge {
            position: static;
            margin-top: 1rem;
            text-align: center;
        }
    }
    
    /* Scrollbar Styling */
    .contractors-grid::-webkit-scrollbar {
        width: 6px;
    }
    
    .contractors-grid::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    .contractors-grid::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .contractors-grid::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush
@endsection