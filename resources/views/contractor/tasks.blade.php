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

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
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
                        <i class="fas fa-tools text-info"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->where('task_status', 'in_progress')->count() }}</h3>
                    <p class="text-muted mb-0">In Progress</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stats-card">
                <div class="card-body p-4 text-center">
                    <div class="stats-icon bg-warning-light mb-3">
                        <i class="fas fa-hourglass-half text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $tasks->where('task_status', 'awaiting_approval')->count() }}</h3>
                    <p class="text-muted mb-0">Awaiting Approval</p>
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
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="filter-tabs">
                        <ul class="nav nav-pills nav-fill p-3" id="taskTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                                    <i class="fas fa-list me-2"></i>All Tasks
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">
                                    <i class="fas fa-clock me-2"></i>Pending
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" id="in-progress-tab" data-bs-toggle="pill" data-bs-target="#in-progress" type="button" role="tab" aria-controls="in-progress" aria-selected="false">
                                    <i class="fas fa-tools me-2"></i>In Progress
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" id="awaiting-approval-tab" data-bs-toggle="pill" data-bs-target="#awaiting-approval" type="button" role="tab" aria-controls="awaiting-approval" aria-selected="false">
                                    <i class="fas fa-hourglass-half me-2"></i>Awaiting Approval
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                                    <i class="fas fa-check-circle me-2"></i>Completed
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="row">
        <div class="col-12">
            @if($tasks->count() > 0)
                @foreach($tasks as $task)
                <div class="card border-0 shadow-sm rounded-4 mb-4 task-card" data-status="{{ $task->task_status }}">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-2 col-md-3 mb-3 mb-md-0">
                                <div class="task-date text-center">
                                    <div class="date-card bg-primary-light rounded-3 p-3">
                                        <div class="month text-primary fw-bold">{{ $task->created_at->format('M') }}</div>
                                        <div class="day text-primary fw-bold fs-2">{{ $task->created_at->format('d') }}</div>
                                        <div class="year text-muted small">{{ $task->created_at->format('Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-9 mb-3 mb-lg-0">
                                <div class="task-info">
                                    <h5 class="fw-bold mb-2">{{ $task->report->room->house->house_address }}</h5>
                                    <div class="task-meta mb-2">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="fas fa-home me-1"></i>{{ $task->report->room->room_type }}
                                        </span>
                                        <span class="badge bg-secondary me-2">{{ $task->task_type }}</span>
                                    </div>
                                    <p class="text-muted mb-2">{{ Str::limit($task->report->report_desc, 100) }}</p>
                                    <div class="task-progress">
                                        @php
                                            $progressSteps = [
                                                'pending' => ['label' => 'Task Assigned', 'icon' => 'fas fa-clock', 'color' => 'secondary'],
                                                'in_progress' => ['label' => 'Work in Progress', 'icon' => 'fas fa-tools', 'color' => 'info'],
                                                'awaiting_approval' => ['label' => 'Awaiting Approval', 'icon' => 'fas fa-hourglass-half', 'color' => 'warning'],
                                                'completed' => ['label' => 'Completed', 'icon' => 'fas fa-check-circle', 'color' => 'success']
                                            ];
                                            $currentStep = $progressSteps[$task->task_status] ?? $progressSteps['pending'];
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $currentStep['icon'] }} text-{{ $currentStep['color'] }} me-2"></i>
                                            <span class="badge bg-{{ $currentStep['color'] }}">{{ $currentStep['label'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                @if($task->report->report_image)
                                <div class="task-image">
                                    <img src="{{ asset('storage/' . $task->report->report_image) }}" alt="Issue" class="img-fluid rounded-3 shadow-sm" style="height: 80px; width: 80px; object-fit: cover;">
                                    <a href="#" class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#imageModal{{ $task->taskID }}">
                                        <i class="fas fa-eye me-1"></i>View Image
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="task-actions text-end">
                                    <!-- Maintenance Progress Actions -->
                                    @if($task->task_status == 'pending')
                                        <form action="{{ route('contractor.tasks.update-progress', $task->taskID) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="start_work">
                                            <button type="submit" class="btn btn-info btn-sm rounded-pill px-3">
                                                <i class="fas fa-play me-1"></i>Start Work
                                            </button>
                                        </form>
                                    @elseif($task->task_status == 'in_progress')
                                        <button class="btn btn-warning btn-sm rounded-pill px-3 mb-2" data-bs-toggle="modal" data-bs-target="#completionModal{{ $task->taskID }}">
                                            <i class="fas fa-upload me-1"></i>Submit Completion
                                        </button>
                                    @elseif($task->task_status == 'awaiting_approval')
                                        <div class="alert alert-warning alert-sm p-2 mb-2">
                                            <i class="fas fa-hourglass-half me-1"></i>
                                            <small>Waiting for landlord approval</small>
                                        </div>
                                        @if($task->completion_image)
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#completionProofModal{{ $task->taskID }}">
                                                <i class="fas fa-image me-1"></i>View Proof
                                            </button>
                                        @endif
                                    @elseif($task->task_status == 'completed')
                                        <div class="alert alert-success alert-sm p-2 mb-2">
                                            <i class="fas fa-check-circle me-1"></i>
                                            <small>Task Completed</small>
                                        </div>
                                    @endif
                                    
                                    <button class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->taskID }}">
                                        <i class="fas fa-eye me-1"></i>Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completion Submission Modal -->
                @if($task->task_status == 'in_progress')
                <div class="modal fade" id="completionModal{{ $task->taskID }}" tabindex="-1" aria-labelledby="completionModalLabel{{ $task->taskID }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-4">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold" id="completionModalLabel{{ $task->taskID }}">
                                    <i class="fas fa-upload me-2 text-warning"></i>Submit Task Completion
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('contractor.tasks.update-progress', $task->taskID) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="submit_completion">
                                <div class="modal-body">
                                    <div class="alert alert-info border-0 rounded-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please upload proof of completion and add any notes about the work performed.
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="completion_image{{ $task->taskID }}" class="form-label fw-bold">
                                            <i class="fas fa-camera me-2"></i>Completion Proof Image *
                                        </label>
                                        <input type="file" class="form-control @error('completion_image') is-invalid @enderror" id="completion_image{{ $task->taskID }}" name="completion_image" accept="image/*" required>
                                        @error('completion_image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-text">Upload a clear image showing the completed work.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="completion_notes{{ $task->taskID }}" class="form-label fw-bold">
                                            <i class="fas fa-sticky-note me-2"></i>Completion Notes
                                        </label>
                                        <textarea class="form-control @error('completion_notes') is-invalid @enderror" id="completion_notes{{ $task->taskID }}" name="completion_notes" rows="3" placeholder="Describe the work performed, materials used, or any important details..."></textarea>
                                        @error('completion_notes')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-warning rounded-pill">
                                        <i class="fas fa-paper-plane me-2"></i>Submit for Approval
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Completion Proof Modal -->
                @if($task->task_status == 'awaiting_approval' && $task->completion_image)
                <div class="modal fade" id="completionProofModal{{ $task->taskID }}" tabindex="-1" aria-labelledby="completionProofModalLabel{{ $task->taskID }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-4">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold" id="completionProofModalLabel{{ $task->taskID }}">
                                    <i class="fas fa-image me-2 text-primary"></i>Completion Proof
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $task->completion_image) }}" alt="Completion Proof" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 400px;">
                                @if($task->completion_notes)
                                    <div class="alert alert-light border rounded-3">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-sticky-note me-2"></i>Completion Notes:</h6>
                                        <p class="mb-0">{{ $task->completion_notes }}</p>
                                    </div>
                                @endif
                                <div class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>Submitted: {{ $task->submitted_at ? $task->submitted_at->format('M d, Y h:i A') : 'N/A' }}
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Task Detail Modal -->
                <div class="modal fade" id="taskModal{{ $task->taskID }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->taskID }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-4">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold" id="taskModalLabel{{ $task->taskID }}">Task Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Property Information -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-home me-2 text-primary"></i>Property Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item mb-2">
                                                <strong>Address:</strong>
                                                <span class="text-muted">{{ $task->report->room->house->house_address }}</span>
                                            </div>
                                            <div class="info-item mb-2">
                                                <strong>Room:</strong>
                                                <span class="text-muted">{{ $task->report->room->room_type }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item mb-2">
                                                <strong>Item:</strong>
                                                <span class="text-muted">{{ $task->report->item->item_name }}</span>
                                            </div>
                                            <div class="info-item mb-2">
                                                <strong>Task Type:</strong>
                                                <span class="badge bg-secondary">{{ $task->task_type }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Task Information -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-tasks me-2 text-primary"></i>Task Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item mb-2">
                                                <strong>Status:</strong>
                                                @php $currentStep = $progressSteps[$task->task_status] ?? $progressSteps['pending']; @endphp
                                                <span class="badge bg-{{ $currentStep['color'] }}">{{ $currentStep['label'] }}</span>
                                            </div>
                                            <div class="info-item mb-2">
                                                <strong>Created:</strong>
                                                <span class="text-muted">{{ $task->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if($task->completed_at)
                                            <div class="info-item mb-2">
                                                <strong>Completed:</strong>
                                                <span class="text-muted">{{ $task->completed_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                            @endif
                                            @if($task->submitted_at)
                                            <div class="info-item mb-2">
                                                <strong>Submitted:</strong>
                                                <span class="text-muted">{{ $task->submitted_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Issue Description -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-exclamation-triangle me-2 text-primary"></i>Issue Description</h6>
                                    <p class="text-muted">{{ $task->report->report_desc }}</p>
                                </div>

                                <!-- Issue Image -->
                                @if($task->report->report_image)
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-image me-2 text-primary"></i>Issue Image</h6>
                                    <img src="{{ asset('storage/' . $task->report->report_image) }}" alt="Issue Image" class="img-fluid rounded-3 shadow-sm" style="max-height: 300px;">
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Modal -->
                @if($task->report->report_image)
                <div class="modal fade" id="imageModal{{ $task->taskID }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $task->taskID }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-4">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold" id="imageModalLabel{{ $task->taskID }}">Issue Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $task->report->report_image) }}" alt="Issue Image" class="img-fluid rounded-3 shadow-sm">
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-tasks fa-4x text-muted opacity-50"></i>
                        </div>
                        <h4 class="fw-bold text-muted mb-3">No Tasks Available</h4>
                        <p class="text-muted mb-4">You don't have any maintenance tasks assigned yet.</p>
                        <a href="{{ route('contractor.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.stats-card {
    transition: transform 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.bg-warning-light {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-info-light {
    background-color: rgba(13, 202, 240, 0.1);
}

.bg-success-light {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-primary-light {
    background-color: rgba(13, 110, 253, 0.1);
}

.task-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.task-card[data-status="pending"] {
    border-left-color: #6c757d;
}

.task-card[data-status="in_progress"] {
    border-left-color: #0dcaf0;
}

.task-card[data-status="awaiting_approval"] {
    border-left-color: #ffc107;
}

.task-card[data-status="completed"] {
    border-left-color: #198754;
}

.date-card {
    min-width: 80px;
}

.welcome-icon {
    font-size: 2.5rem;
    opacity: 0.7;
}

.filter-tabs .nav-link {
    border: 2px solid transparent;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-tabs .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.1);
    border-color: rgba(13, 110, 253, 0.2);
}

.filter-tabs .nav-link.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.alert-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('#taskTabs button[data-bs-toggle="pill"]');
    const taskCards = document.querySelectorAll('.task-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const targetStatus = e.target.getAttribute('aria-controls');
            
            taskCards.forEach(card => {
                if (targetStatus === 'all') {
                    card.style.display = 'block';
                } else {
                    const cardStatus = card.getAttribute('data-status').replace('_', '-');
                    if (cardStatus === targetStatus) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>
@endsection