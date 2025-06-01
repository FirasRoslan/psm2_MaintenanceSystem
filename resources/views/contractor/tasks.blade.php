@extends('ui.layout')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header bg-gradient-warning text-white rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 fw-bold">My Tasks</h2>
                        <p class="mb-0 opacity-90">View and manage your assigned maintenance tasks</p>
                    </div>
                    <div class="text-end">
                        <div class="welcome-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-white bg-opacity-10 rounded-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Track and update the status of your maintenance assignments efficiently.</span>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('contractor.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Tasks</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
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
        </div>
    </div>

    <!-- Task Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stats-card">
                <div class="card-body p-4 text-center">
                    <div class="stats-icon bg-warning-light mb-3">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->where('task_status', 'pending')->count() }}</h3>
                    <p class="text-muted mb-0">Pending Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stats-card">
                <div class="card-body p-4 text-center">
                    <div class="stats-icon bg-info-light mb-3">
                        <i class="fas fa-spinner text-info"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->where('task_status', 'in_progress')->count() }}</h3>
                    <p class="text-muted mb-0">In Progress</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stats-card">
                <div class="card-body p-4 text-center">
                    <div class="stats-icon bg-success-light mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->where('task_status', 'completed')->count() }}</h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stats-card">
                <div class="card-body p-4 text-center">
                    <div class="stats-icon bg-primary-light mb-3">
                        <i class="fas fa-list text-primary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->count() }}</h3>
                    <p class="text-muted mb-0">Total Tasks</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-light me-3">
                                <i class="fas fa-tasks text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Task Management</h5>
                                <small class="text-muted">Manage and update your assigned tasks</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($tasks->count() > 0)
                        <div class="task-list">
                            @foreach($tasks as $task)
                                <div class="task-item p-4 border-bottom task-status-{{ $task->task_status }}" data-status="{{ $task->task_status }}">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2 col-md-3 mb-3 mb-md-0">
                                            <div class="task-date">
                                                <div class="date-badge bg-light rounded-3 p-3 text-center">
                                                    <div class="fw-bold text-primary">{{ $task->created_at->format('M') }}</div>
                                                    <div class="h4 fw-bold mb-0">{{ $task->created_at->format('d') }}</div>
                                                    <div class="small text-muted">{{ $task->created_at->format('Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                                            <div class="task-property">
                                                <h6 class="fw-bold mb-1">{{ $task->report->room->house->house_address }}</h6>
                                                <div class="d-flex align-items-center text-muted small mb-1">
                                                    <i class="fas fa-door-open me-1"></i>
                                                    <span>{{ $task->report->room->room_type }}</span>
                                                </div>
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="fas fa-tools me-1"></i>
                                                    <span>{{ $task->report->item->item_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-5 mb-3 mb-md-0">
                                            <div class="task-details">
                                                <div class="mb-2">
                                                    <span class="badge bg-secondary rounded-pill">{{ $task->task_type }}</span>
                                                </div>
                                                <p class="mb-2 small text-muted">{{ \Illuminate\Support\Str::limit($task->report->report_desc, 80) }}</p>
                                                <div class="task-status-badge">
                                                    @if($task->task_status == 'pending')
                                                        <span class="badge bg-warning-light text-warning rounded-pill px-3 py-2">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @elseif($task->task_status == 'in_progress')
                                                        <span class="badge bg-info-light text-info rounded-pill px-3 py-2">
                                                            <i class="fas fa-spinner me-1"></i>In Progress
                                                        </span>
                                                    @elseif($task->task_status == 'completed')
                                                        <span class="badge bg-success-light text-success rounded-pill px-3 py-2">
                                                            <i class="fas fa-check-circle me-1"></i>Completed
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                                            <div class="task-image text-center">
                                                @if($task->report->report_image)
                                                    <a href="{{ asset('storage/' . $task->report->report_image) }}" target="_blank" class="image-preview-link">
                                                        <img src="{{ asset('storage/' . $task->report->report_image) }}" alt="Task Image" class="img-fluid rounded-3 shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                                                        <div class="mt-1">
                                                            <small class="text-primary"><i class="fas fa-external-link-alt me-1"></i>View Image</small>
                                                        </div>
                                                    </a>
                                                @else
                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 60px; margin: 0 auto;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    <div class="mt-1">
                                                        <small class="text-muted">No Image</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="task-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle rounded-pill px-3" type="button" id="dropdownMenuButton{{ $task->taskID }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-cog me-1"></i>Actions
                                                    </button>
                                                    <ul class="dropdown-menu shadow border-0 rounded-3" aria-labelledby="dropdownMenuButton{{ $task->taskID }}">
                                                        @if($task->task_status == 'pending')
                                                            <li>
                                                                <form action="{{ route('contractor.tasks.update-status', $task->taskID) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="in_progress">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-play text-info me-2"></i>Start Task
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if($task->task_status != 'completed')
                                                            <li>
                                                                <form action="{{ route('contractor.tasks.update-status', $task->taskID) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="completed">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-check text-success me-2"></i>Mark Complete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->taskID }}">
                                                                <i class="fas fa-eye text-primary me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Task Detail Modal -->
                                <div class="modal fade" id="taskModal{{ $task->taskID }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->taskID }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="taskModalLabel{{ $task->taskID }}">
                                                    <i class="fas fa-tasks me-2"></i>Task Details
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="fw-bold text-muted mb-2">Property Information</h6>
                                                        <div class="bg-light rounded-3 p-3">
                                                            <div class="mb-2">
                                                                <strong>Address:</strong> {{ $task->report->room->house->house_address }}
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Room:</strong> {{ $task->report->room->room_type }}
                                                            </div>
                                                            <div>
                                                                <strong>Item:</strong> {{ $task->report->item->item_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6 class="fw-bold text-muted mb-2">Task Information</h6>
                                                        <div class="bg-light rounded-3 p-3">
                                                            <div class="mb-2">
                                                                <strong>Type:</strong> {{ $task->task_type }}
                                                            </div>
                                                            <div class="mb-2">
                                                                <strong>Assigned:</strong> {{ $task->created_at->format('M d, Y') }}
                                                            </div>
                                                            <div>
                                                                <strong>Status:</strong>
                                                                @if($task->task_status == 'pending')
                                                                    <span class="badge bg-warning">Pending</span>
                                                                @elseif($task->task_status == 'in_progress')
                                                                    <span class="badge bg-info">In Progress</span>
                                                                @elseif($task->task_status == 'completed')
                                                                    <span class="badge bg-success">Completed</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-2">Issue Description</h6>
                                                    <div class="bg-light rounded-3 p-3">
                                                        {{ $task->report->report_desc }}
                                                    </div>
                                                </div>
                                                @if($task->report->report_image)
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-2">Issue Image</h6>
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/' . $task->report->report_image) }}" alt="Issue Image" class="img-fluid rounded-3 shadow" style="max-height: 300px;">
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Close
                                                </button>
                                                @if($task->task_status != 'completed')
                                                <form action="{{ route('contractor.tasks.update-status', $task->taskID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-success rounded-pill">
                                                        <i class="fas fa-check me-1"></i>Mark as Completed
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5 class="fw-bold mb-2">No Tasks Assigned</h5>
                            <p class="text-muted mb-4">You don't have any maintenance tasks assigned yet.</p>
                            <a href="{{ route('contractor.find-landlords') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-search me-2"></i>Find Landlords
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Modern Color Palette */
    :root {
        --primary-color: #6366f1;
        --primary-light: #e0e7ff;
        --success-color: #10b981;
        --success-light: #d1fae5;
        --warning-color: #f59e0b;
        --warning-light: #fef3c7;
        --info-color: #06b6d4;
        --info-light: #cffafe;
        --danger-color: #ef4444;
        --danger-light: #fee2e2;
    }

    /* Enhanced Border Radius */
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    /* Gradient Backgrounds */
    .bg-gradient-warning {
        background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    }

    /* Welcome Header */
    .welcome-header {
        position: relative;
        overflow: hidden;
    }
    
    .welcome-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    /* Stats Cards */
    .stats-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto;
    }

    /* Color Variants */
    .bg-primary-light {
        background-color: var(--primary-light) !important;
    }
    
    .bg-success-light {
        background-color: var(--success-light) !important;
    }
    
    .bg-warning-light {
        background-color: var(--warning-light) !important;
    }
    
    .bg-info-light {
        background-color: var(--info-light) !important;
    }
    
    .text-primary {
        color: var(--primary-color) !important;
    }
    
    .text-success {
        color: var(--success-color) !important;
    }
    
    .text-warning {
        color: var(--warning-color) !important;
    }
    
    .text-info {
        color: var(--info-color) !important;
    }

    /* Icon Boxes */
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Task Items */
    .task-item {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        margin: 0.25rem;
    }
    
    .task-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }
    
    .task-item:last-child {
        border-bottom: none !important;
    }

    /* Date Badge */
    .date-badge {
        border: 2px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    
    .task-item:hover .date-badge {
        border-color: var(--primary-color);
        background-color: var(--primary-light) !important;
    }

    /* Status Badges */
    .bg-success-light {
        background-color: var(--success-light) !important;
        color: var(--success-color) !important;
    }
    
    .bg-warning-light {
        background-color: var(--warning-light) !important;
        color: var(--warning-color) !important;
    }
    
    .bg-info-light {
        background-color: var(--info-light) !important;
        color: var(--info-color) !important;
    }

    /* Image Preview */
    .image-preview-link {
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .image-preview-link:hover img {
        transform: scale(1.05);
    }

    /* Empty State */
    .empty-state-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2.5rem;
        color: #64748b;
    }

    /* Button Enhancements */
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 500;
    }
    
    .btn-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
        transform: translateY(-1px);
    }

    /* Card Enhancements */
    .card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    /* Dropdown Enhancements */
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .modal-header {
        border-bottom: none;
    }
    
    .modal-footer {
        border-top: none;
    }

    /* Filter Functionality */
    .task-item.hidden {
        display: none;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: none;
        padding: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #6b7280;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        .welcome-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .task-item {
            padding: 1rem !important;
        }
        
        .task-item:hover {
            transform: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Status Filter Functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        const selectedStatus = this.value;
        const taskItems = document.querySelectorAll('.task-item');
        
        taskItems.forEach(function(item) {
            const taskStatus = item.getAttribute('data-status');
            
            if (selectedStatus === '' || taskStatus === selectedStatus) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection

<!-- Add this section after the existing task cards -->
@foreach($tasks as $task)
<div class="task-management-card mb-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $task->task_type }}</h5>
                    <p class="text-muted mb-0">{{ $task->report->room->house->house_address }}</p>
                </div>
                <span class="badge bg-{{ $task->task_status == 'completed' ? 'success' : ($task->task_status == 'in_progress' ? 'warning' : 'secondary') }} rounded-pill px-3 py-2">
                    {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                </span>
            </div>
        </div>
        
        <div class="card-body p-4">
            <!-- Phase Management -->
            @if($task->phases->count() > 0)
            <h6 class="mb-3">Phase Management</h6>
            <div class="phases-container">
                @foreach($task->phases as $phase)
                <div class="phase-management-item mb-3 p-3 border rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Phase {{ $phase->arrangement_number }}</h6>
                        <span class="badge bg-{{ $phase->phase_status == 'completed' ? 'success' : ($phase->phase_status == 'in_progress' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $phase->phase_status)) }}
                        </span>
                    </div>
                    
                    @if($phase->phase_status != 'completed')
                    <form action="{{ route('contractor.phases.update-status', $phase->phaseID) }}" method="POST" enctype="multipart/form-data" class="phase-update-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phase Status</label>
                                <select name="phase_status" class="form-select" required>
                                    <option value="pending" {{ $phase->phase_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $phase->phase_status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $phase->phase_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phase Image (Optional)</label>
                                <input type="file" name="phase_image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Update Phase
                        </button>
                    </form>
                    @endif
                    
                    @if($phase->phase_image)
                    <div class="mt-3">
                        <img src="{{ Storage::url($phase->phase_image) }}" alt="Phase {{ $phase->arrangement_number }}" class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <!-- Create Phases Button -->
            @if($task->task_status == 'pending')
            <form action="{{ route('contractor.tasks.create-phases', $task->taskID) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i>Create Task Phases
                </button>
            </form>
            @endif
            @endif
        </div>
    </div>
</div>
@endforeach