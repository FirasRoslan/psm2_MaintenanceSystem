@extends('ui.layout')

@section('title', 'Maintenance Request Details')

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
                            <li class="breadcrumb-item">
                                <a href="{{ route('landlord.requests.index') }}" class="text-decoration-none">
                                    <i class="fas fa-tools me-1"></i>Maintenance Requests
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Request Details</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-eye me-3"></i>Maintenance Request Details
                    </h1>
                    <p class="page-subtitle mb-0">View detailed information about this maintenance request</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Requests
                    </a>
                    @if($report->report_status == 'Pending')
                        <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="btn btn-modern-primary">
                            <i class="fas fa-user-hard-hat me-2"></i>Assign Task
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    <div class="status-alert mb-4">
        <div class="status-card 
            @if($report->report_status == 'Pending') status-pending
            @elseif($report->report_status == 'In Progress') status-progress
            @elseif($report->report_status == 'Completed') status-completed
            @else status-rejected
            @endif">
            <div class="status-icon">
                <i class="fas fa-
                    @if($report->report_status == 'Pending') clock
                    @elseif($report->report_status == 'In Progress') tools
                    @elseif($report->report_status == 'Completed') check-circle
                    @else times-circle
                    @endif"></i>
            </div>
            <div class="status-content">
                <h5 class="status-title">{{ $report->report_status }}</h5>
                <p class="status-subtitle">Submitted on {{ $report->created_at->format('F d, Y \\a\\t g:i A') }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Request Overview -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="header-content">
                        <h5 class="card-title">Request Overview</h5>
                        <p class="card-subtitle">Basic information about the maintenance request</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Item/Component</span>
                                <span class="info-value">{{ $report->item->item_name }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Property Address</span>
                                <span class="info-value">{{ $report->room->house->house_address }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Room</span>
                                <span class="info-value">{{ $report->room->room_type }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Reported Date</span>
                                <span class="info-value">{{ $report->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="header-content">
                        <h5 class="card-title">Description</h5>
                        <p class="card-subtitle">Detailed description of the issue</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="description-content">
                        <p>{{ $report->report_desc }}</p>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            @if($report->report_image)
            <div class="detail-card mb-4">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="header-content">
                        <h5 class="card-title">Attached Image</h5>
                        <p class="card-subtitle">Visual documentation of the issue</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $report->report_image) }}" 
                             alt="Maintenance Issue" 
                             class="detail-image"
                             data-bs-toggle="modal" 
                             data-bs-target="#imageModal">
                        <div class="image-overlay">
                            <i class="fas fa-search-plus"></i>
                            <span>Click to enlarge</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Task Information -->
            @if($report->tasks->isNotEmpty())
            <div class="detail-card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="header-content">
                        <h5 class="card-title">Assigned Tasks</h5>
                        <p class="card-subtitle">Contractors assigned to this request</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tasks-list">
                        @foreach($report->tasks as $task)
                        <div class="task-item">
                            <div class="task-avatar">
                                {{ substr($task->contractor->name, 0, 1) }}
                            </div>
                            <div class="task-content">
                                <h6 class="task-name">{{ $task->contractor->name }}</h6>
                                <p class="task-type">{{ $task->task_type }}</p>
                                @if($task->completed_at)
                                <div class="task-completion">
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    Completed on {{ \Carbon\Carbon::parse($task->completed_at)->format('M d, Y \\a\\t g:i A') }}
                                </div>
                                @endif
                            </div>
                            <div class="task-status">
                                <span class="status-badge 
                                    @if($task->task_status == 'pending') pending
                                    @elseif($task->task_status == 'in_progress') in-progress
                                    @elseif($task->task_status == 'completed') completed
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Tenant Information -->
            <div class="detail-card mb-4">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="header-content">
                        <h6 class="card-title">Reported By</h6>
                        <p class="card-subtitle">Tenant information</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tenant-profile">
                        <div class="tenant-avatar">
                            {{ substr($report->user->name, 0, 1) }}
                        </div>
                        <div class="tenant-info">
                            <h6 class="tenant-name">{{ $report->user->name }}</h6>
                            <p class="tenant-email">{{ $report->user->email }}</p>
                            @if($report->user->phone)
                            <p class="tenant-phone">
                                <i class="fas fa-phone me-1"></i>{{ $report->user->phone }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="detail-card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="header-content">
                        <h6 class="card-title">Quick Actions</h6>
                        <p class="card-subtitle">Manage request status</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="actions-grid">
                        @if($report->report_status == 'Pending')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="In Progress">
                            <button type="submit" class="btn btn-action btn-info">
                                <i class="fas fa-tools"></i>
                                <span>Mark as In Progress</span>
                            </button>
                        </form>
                        @endif

                        @if($report->report_status != 'Completed')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Completed">
                            <button type="submit" class="btn btn-action btn-success">
                                <i class="fas fa-check-circle"></i>
                                <span>Mark as Completed</span>
                            </button>
                        </form>
                        @endif

                        @if($report->report_status == 'Pending')
                        <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="btn btn-action btn-primary">
                            <i class="fas fa-user-hard-hat"></i>
                            <span>Assign to Contractor</span>
                        </a>
                        @endif

                        @if($report->report_status != 'Rejected')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Rejected">
                            <button type="submit" class="btn btn-action btn-danger" onclick="return confirm('Are you sure you want to reject this request?')">
                                <i class="fas fa-times-circle"></i>
                                <span>Reject Request</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
@if($report->report_image)
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Maintenance Issue Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ asset('storage/' . $report->report_image) }}" 
                     alt="Maintenance Issue" 
                     class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>
@endif

<style>
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --text-color: #1f2937;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f8fafc;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
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

.status-alert {
    margin-bottom: 2rem;
}

.status-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    border-radius: 16px;
    border: 2px solid;
    transition: all 0.3s ease;
}

.status-pending {
    background: rgba(251, 191, 36, 0.1);
    border-color: rgba(251, 191, 36, 0.3);
    color: #d97706;
}

.status-progress {
    background: rgba(59, 130, 246, 0.1);
    border-color: rgba(59, 130, 246, 0.3);
    color: #2563eb;
}

.status-completed {
    background: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.3);
    color: #16a34a;
}

.status-rejected {
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

.status-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: currentColor;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.status-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: currentColor;
}

.status-subtitle {
    margin: 0;
    opacity: 0.8;
    font-size: 0.95rem;
}

.detail-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-header {
    background: var(--bg-light);
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
    display: flex;
    align-items: center;
}

.header-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.25rem;
}

.card-subtitle {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: var(--bg-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1rem;
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
    margin-bottom: 0.25rem;
}

.info-value {
    display: block;
    font-weight: 600;
    color: var(--text-color);
    font-size: 1rem;
}

.description-content {
    background: var(--bg-light);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
}

.description-content p {
    color: var(--text-color);
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
}

.image-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
}

.detail-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-container:hover .image-overlay {
    opacity: 1;
}

.image-container:hover .detail-image {
    transform: scale(1.05);
}

.image-overlay i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.tasks-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.task-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-light);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.task-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.task-content {
    flex: 1;
    min-width: 0;
}

.task-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.25rem;
}

.task-type {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.task-completion {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.task-status {
    flex-shrink: 0;
}

.tenant-profile {
    display: flex;
    align-items: center;
}

.tenant-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.tenant-info {
    flex: 1;
    min-width: 0;
}

.tenant-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.25rem;
}

.tenant-email,
.tenant-phone {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.875rem 1rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-action i {
    margin-right: 0.5rem;
    font-size: 1rem;
}

.btn-action.btn-info {
    background: linear-gradient(135deg, var(--info-color), #1d4ed8);
    color: white;
}

.btn-action.btn-success {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
}

.btn-action.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
}

.btn-action.btn-danger {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    color: white;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
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
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .status-card {
        flex-direction: column;
        text-align: center;
    }
    
    .status-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }
    
    .tenant-profile {
        flex-direction: column;
        text-align: center;
    }
    
    .tenant-avatar {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>
@endsection