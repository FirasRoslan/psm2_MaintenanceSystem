@extends('ui.layout')

@section('title', 'Maintenance Request Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-5">
        <div class="header-content">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="breadcrumb-nav mb-2">
                        <span class="breadcrumb-item">Dashboard</span>
                        <i class="fas fa-chevron-right mx-2 text-muted"></i>
                        <a href="{{ route('landlord.requests.index') }}" class="breadcrumb-item">Maintenance Requests</a>
                        <i class="fas fa-chevron-right mx-2 text-muted"></i>
                        <span class="breadcrumb-item active">Request Details</span>
                    </div>
                    <h2 class="page-title mb-2">Maintenance Request Details</h2>
                    <p class="page-description">View detailed information about this maintenance request</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-outline-light btn-sm rounded-pill me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Requests
                    </a>
                    @if($report->report_status == 'Pending')
                        <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="btn btn-light btn-sm rounded-pill">
                            <i class="fas fa-user-hard-hat me-2"></i>Assign Task
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Request Details -->
        <div class="col-lg-8">
            <div class="main-card mb-4">
                <div class="card-header-modern">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="header-info">
                            <h5 class="mb-1">Request Information</h5>
                            <p class="text-muted mb-0">Submitted on {{ $report->created_at->format('F d, Y \\a\\t g:i A') }}</p>
                        </div>
                        <div class="status-badge-large">
                            @if($report->report_status == 'Pending')
                                <span class="badge bg-warning-soft text-warning status-large">
                                    <i class="fas fa-clock me-2"></i>Pending
                                </span>
                            @elseif($report->report_status == 'In Progress')
                                <span class="badge bg-info-soft text-info status-large">
                                    <i class="fas fa-tools me-2"></i>In Progress
                                </span>
                            @elseif($report->report_status == 'Completed')
                                <span class="badge bg-success-soft text-success status-large">
                                    <i class="fas fa-check-circle me-2"></i>Completed
                                </span>
                            @elseif($report->report_status == 'Rejected')
                                <span class="badge bg-danger-soft text-danger status-large">
                                    <i class="fas fa-times-circle me-2"></i>Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Property and Room Information -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">Property & Location</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Property Address</span>
                                        <span class="info-value">{{ $report->room->house->house_address }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Room</span>
                                        <span class="info-value">{{ $report->room->room_type }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Issue Details -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">Issue Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-label">Item/Component</span>
                                        <span class="info-value">{{ $report->item->item_name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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

                    <!-- Description -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">Description</h6>
                        <div class="description-box">
                            <p class="mb-0">{{ $report->report_desc }}</p>
                        </div>
                    </div>

                    <!-- Image Section -->
                    @if($report->report_image)
                    <div class="info-section">
                        <h6 class="section-title">Attached Image</h6>
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $report->report_image) }}" alt="Maintenance Issue" class="report-image" data-bs-toggle="modal" data-bs-target="#imageModal">
                            <div class="image-overlay">
                                <i class="fas fa-search-plus"></i>
                                <span>Click to enlarge</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Task Information -->
            @if($report->tasks->isNotEmpty())
            <div class="main-card">
                <div class="card-header-modern">
                    <div class="header-info">
                        <h5 class="mb-1">Assigned Tasks</h5>
                        <p class="text-muted mb-0">Tasks assigned to contractors for this request</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @foreach($report->tasks as $task)
                    <div class="task-card">
                        <div class="task-header">
                            <div class="contractor-info">
                                <div class="contractor-avatar">
                                    <i class="fas fa-user-hard-hat"></i>
                                </div>
                                <div class="contractor-details">
                                    <h6 class="contractor-name">{{ $task->contractor->name }}</h6>
                                    <span class="task-type">{{ $task->task_type }}</span>
                                </div>
                            </div>
                            <div class="task-status">
                                @if($task->task_status == 'pending')
                                    <span class="badge bg-warning-soft text-warning">
                                        <i class="fas fa-clock me-1"></i>Pending
                                    </span>
                                @elseif($task->task_status == 'in_progress')
                                    <span class="badge bg-info-soft text-info">
                                        <i class="fas fa-tools me-1"></i>In Progress
                                    </span>
                                @elseif($task->task_status == 'completed')
                                    <span class="badge bg-success-soft text-success">
                                        <i class="fas fa-check-circle me-1"></i>Completed
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($task->completed_at)
                        <div class="task-completion">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span class="text-muted">Completed on {{ \Carbon\Carbon::parse($task->completed_at)->format('M d, Y \\a\\t g:i A') }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Tenant Information -->
            <div class="sidebar-card mb-4">
                <div class="sidebar-header">
                    <h6 class="mb-0">Reported By</h6>
                </div>
                <div class="sidebar-body">
                    <div class="tenant-profile">
                        <div class="tenant-avatar">
                            {{ substr($report->user->name, 0, 1) }}
                        </div>
                        <div class="tenant-info">
                            <h6 class="tenant-name">{{ $report->user->name }}</h6>
                            <p class="tenant-email">{{ $report->user->email }}</p>
                            @if($report->user->phone)
                            <p class="tenant-phone">
                                <i class="fas fa-phone me-2"></i>{{ $report->user->phone }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="sidebar-body">
                    <div class="action-buttons">
                        @if($report->report_status == 'Pending')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="In Progress">
                            <button type="submit" class="btn btn-info w-100 rounded-pill">
                                <i class="fas fa-tools me-2"></i>Mark as In Progress
                            </button>
                        </form>
                        @endif

                        @if($report->report_status != 'Completed')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Completed">
                            <button type="submit" class="btn btn-success w-100 rounded-pill">
                                <i class="fas fa-check-circle me-2"></i>Mark as Completed
                            </button>
                        </form>
                        @endif

                        @if($report->report_status != 'Rejected')
                        <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Rejected">
                            <button type="submit" class="btn btn-danger w-100 rounded-pill" onclick="return confirm('Are you sure you want to reject this request?')">
                                <i class="fas fa-times-circle me-2"></i>Reject Request
                            </button>
                        </form>
                        @endif

                        @if($report->report_status == 'Pending')
                        <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="btn btn-primary-gradient w-100 rounded-pill">
                            <i class="fas fa-user-hard-hat me-2"></i>Assign to Contractor
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
@if($report->report_image)
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="imageModalLabel">Maintenance Issue Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ asset('storage/' . $report->report_image) }}" alt="Maintenance Issue" class="img-fluid w-100 rounded-bottom-4">
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-nav {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .breadcrumb-nav a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb-nav a:hover {
        color: white;
    }

    .breadcrumb-item.active {
        font-weight: 600;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions .btn {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .header-actions .btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        color: white;
    }

    /* Main Card Styling */
    .main-card, .sidebar-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .card-header-modern, .sidebar-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-header {
        padding: 1rem 1.5rem;
    }

    .header-info h5 {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .sidebar-body {
        padding: 1.5rem;
    }

    /* Status Badges */
    .status-badge-large .status-large {
        font-size: 1rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
    }

    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.1) !important;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .bg-info-soft {
        background-color: rgba(13, 202, 240, 0.1) !important;
        border: 1px solid rgba(13, 202, 240, 0.2);
    }

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1) !important;
        border: 1px solid rgba(25, 135, 84, 0.2);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1) !important;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    /* Info Sections */
    .info-section {
        border-bottom: 1px solid #f1f3f4;
        padding-bottom: 1.5rem;
    }

    .info-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .section-title {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
        margin-right: 0.75rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .info-content {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #2d3748;
        font-weight: 600;
    }

    /* Description Box */
    .description-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #495057;
    }

    /* Image Container */
    .image-container {
        position: relative;
        display: inline-block;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .report-image {
        max-width: 300px;
        height: auto;
        display: block;
        border-radius: 12px;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .image-container:hover .image-overlay {
        opacity: 1;
    }

    .image-overlay i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    /* Task Cards */
    .task-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .task-card:last-child {
        margin-bottom: 0;
    }

    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .contractor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .contractor-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .contractor-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.25rem 0;
    }

    .task-type {
        font-size: 0.875rem;
        color: #6c757d;
        background: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        border: 1px solid #dee2e6;
    }

    .task-completion {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
    }

    /* Tenant Profile */
    .tenant-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .tenant-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .tenant-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.25rem 0;
    }

    .tenant-email, .tenant-phone {
        font-size: 0.875rem;
        color: #6c757d;
        margin: 0.25rem 0;
    }

    /* Action Buttons */
    .action-buttons .btn {
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }

    .btn-primary-gradient:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .header-actions {
            margin-top: 1rem;
        }

        .card-header-modern {
            padding: 1rem;
        }

        .info-item {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .task-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .tenant-profile {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .report-image {
            max-width: 100%;
        }

        .action-buttons .btn {
            font-size: 0.875rem;
        }
    }
</style>
@endpush
@endsection