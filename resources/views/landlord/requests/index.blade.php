@extends('ui.layout')

@section('title', 'Maintenance Requests')

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
                            <li class="breadcrumb-item active">Maintenance Requests</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-tools me-3"></i>Maintenance Requests
                    </h1>
                    <p class="page-subtitle mb-0">View and manage maintenance requests from tenants</p>
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

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Status Filter Tabs -->
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
                    <i class="fas fa-list me-1"></i>All ({{ $reports->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="pending" value="pending">
                <label class="btn btn-filter" for="pending">
                    <i class="fas fa-clock me-1"></i>Pending ({{ $reports->where('report_status', 'Pending')->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="in_progress" value="in_progress">
                <label class="btn btn-filter" for="in_progress">
                    <i class="fas fa-cog me-1"></i>In Progress ({{ $reports->where('report_status', 'In Progress')->count() }})
                </label>
                
                <input type="radio" class="btn-check" name="status" id="completed" value="completed">
                <label class="btn btn-filter" for="completed">
                    <i class="fas fa-check-circle me-1"></i>Completed ({{ $reports->where('report_status', 'Completed')->count() }})
                </label>
            </div>
        </div>
    </div>

    <!-- Requests Grid -->
    @if($reports->count() > 0)
    <div class="requests-grid">
        @foreach($reports as $report)
        <div class="request-card fade-in request-item" data-status="{{ strtolower(str_replace(' ', '_', $report->report_status)) }}">
            <div class="request-header">
                <div class="request-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="request-title-section">
                    <h5 class="request-title">{{ $report->item->item_name }}</h5>
                    <span class="request-date">{{ $report->created_at->format('M d, Y') }}</span>
                </div>
                <span class="status-badge 
                    @if($report->report_status == 'Pending') pending
                    @elseif($report->report_status == 'In Progress') in-progress
                    @elseif($report->report_status == 'Completed') completed
                    @else pending
                    @endif">
                    {{ $report->report_status }}
                </span>
            </div>
            
            <div class="request-content">
                <!-- Tenant Info -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Reported by</span>
                        <span class="info-value">{{ $report->user->name }}</span>
                    </div>
                </div>

                <!-- Property Info -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Property</span>
                        <span class="info-value">{{ $report->room->house->house_address }}</span>
                    </div>
                </div>

                <!-- Room Info -->
                <div class="info-item mb-3">
                    <div class="info-icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Room</span>
                        <span class="info-value">{{ $report->room->room_type }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="description-box mb-3">
                    <p class="mb-0">{{ Str::limit($report->report_desc, 100) }}</p>
                </div>

                <!-- Image Preview -->
                @if($report->report_image)
                <div class="image-preview mb-3">
                    <img src="{{ asset('storage/' . $report->report_image) }}" 
                         alt="Report Image" 
                         class="request-image"
                         data-bs-toggle="modal" 
                         data-bs-target="#imageModal{{ $report->reportID }}">
                </div>
                @endif
            </div>

            <div class="request-actions">
                <a href="{{ route('landlord.requests.show', $report->reportID) }}" 
                   class="btn btn-request-action">
                    <i class="fas fa-eye me-2"></i>View Details
                </a>
                
                @if($report->report_status == 'Pending')
                <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" 
                   class="btn btn-request-action-secondary mt-2">
                    <i class="fas fa-user-plus me-2"></i>Assign Task
                </a>
                @endif
            </div>
        </div>

        <!-- Image Modal -->
        @if($report->report_image)
        <div class="modal fade" id="imageModal{{ $report->reportID }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Report Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="{{ asset('storage/' . $report->report_image) }}" 
                             alt="Report Image" 
                             class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Pagination -->
    @if($reports->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $reports->links() }}
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-content">
            <div class="empty-state-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h4 class="empty-state-title">No Maintenance Requests</h4>
            <p class="empty-state-description">There are currently no maintenance requests to display.</p>
            <a href="{{ route('landlord.dashboard') }}" class="btn btn-modern-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
    @endif
</div>

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --text-color: #1f2937;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f8fafc;
}

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

.filter-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.btn-filter {
    background: var(--bg-light);
    border: 1px solid var(--border-color);
    color: var(--text-color);
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 500;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.btn-filter:hover,
.btn-check:checked + .btn-filter {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.requests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.request-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.request-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.request-card.hidden {
    display: none;
}

.request-header {
    padding: 1.5rem 1.5rem 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.request-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.request-title-section {
    flex: 1;
    min-width: 0;
}

.request-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.request-date {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
    flex-shrink: 0;
}

.status-badge.pending {
    background: rgba(251, 191, 36, 0.1);
    color: #d97706;
    border: 1px solid rgba(251, 191, 36, 0.2);
}

.status-badge.in-progress {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.status-badge.completed {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.request-content {
    padding: 0 1.5rem 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-icon {
    width: 32px;
    height: 32px;
    background: var(--bg-light);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 0.875rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
    min-width: 0;
}

.info-label {
    display: block;
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.info-value {
    display: block;
    font-weight: 600;
    color: var(--text-color);
    font-size: 0.875rem;
}

.description-box {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid var(--border-color);
}

.description-box p {
    color: var(--text-muted);
    font-size: 0.875rem;
    line-height: 1.5;
}

.image-preview {
    border-radius: 12px;
    overflow: hidden;
}

.request-image {
    width: 100%;
    height: 120px;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.request-image:hover {
    transform: scale(1.02);
}

.request-actions {
    padding: 1rem 1.5rem 1.5rem;
}

.btn-request-action {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-request-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    color: white;
}

.btn-request-action-secondary {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
    border: 1px solid rgba(99, 102, 241, 0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-request-action-secondary:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-1px);
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
    .requests-grid {
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
    
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-filter {
        margin-right: 0;
        width: 100%;
    }
}
</style>

@push('scripts')
<script>
// Status Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('input[name="status"]');
    const requestItems = document.querySelectorAll('.request-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('change', function() {
            const status = this.value;
            
            requestItems.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
    });
});
</script>
@endpush
@endsection