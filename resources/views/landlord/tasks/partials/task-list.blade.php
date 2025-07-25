@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($tasks->count() > 0)
    <div class="tasks-grid">
        @foreach($tasks as $task)
        <div class="task-card-wrapper">
            <div class="task-card">
                <!-- Task Header -->
                <div class="task-header">
                    <div class="task-info">
                        <h5 class="task-title">{{ $task->task_type }}</h5>
                        <p class="task-location">{{ $task->report->room->house->house_address }}</p>
                        <p class="task-details">{{ $task->report->room->room_type }} - {{ $task->report->item->item_name }}</p>
                    </div>
                    <div class="task-status">
                        <span class="status-badge 
                            @if($task->task_status == 'pending') status-pending
                            @elseif($task->task_status == 'in_progress') status-progress
                            @elseif($task->task_status == 'awaiting_approval') status-awaiting
                            @elseif($task->task_status == 'completed') status-completed
                            @endif">
                            @if($task->task_status == 'pending') 
                                <i class="fas fa-clock me-1"></i>Pending
                            @elseif($task->task_status == 'in_progress') 
                                <i class="fas fa-tools me-1"></i>In Progress
                            @elseif($task->task_status == 'awaiting_approval') 
                                <i class="fas fa-hourglass-half me-1"></i>Awaiting Approval
                            @elseif($task->task_status == 'completed') 
                                <i class="fas fa-check me-1"></i>Completed
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Contractor Info -->
                <div class="contractor-section">
                    <div class="contractor-info">
                        <div class="contractor-avatar">
                            <span class="initials">{{ substr($task->contractor->name, 0, 1) }}</span>
                        </div>
                        <div class="contractor-details">
                            <h6 class="contractor-name">{{ $task->contractor->name }}</h6>
                            <p class="contractor-email">{{ $task->contractor->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Task Info Footer -->
                <div class="task-footer">
                    <div class="task-meta">
                        <div class="meta-item-single">
                            <i class="fas fa-calendar-alt meta-icon"></i>
                            <div class="meta-content">
                                <span class="meta-label">Assigned</span>
                                <span class="meta-value">{{ $task->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($task->task_status == 'awaiting_approval')
                    <!-- Completion Info Section -->
                    <div class="completion-info mt-3 p-3 bg-light rounded">
                        <h6 class="mb-2"><i class="fas fa-check-circle text-success me-1"></i>Task Completed - Awaiting Your Approval</h6>
                        
                        @if($task->submitted_at)
                        <p class="text-muted mb-2"><small><i class="fas fa-clock me-1"></i>Submitted: {{ $task->submitted_at->format('M d, Y h:i A') }}</small></p>
                        @endif
                        
                        @if($task->completion_notes)
                        <div class="mb-2">
                            <strong>Contractor Notes:</strong>
                            <p class="text-muted mb-0">{{ Str::limit($task->completion_notes, 100) }}</p>
                        </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="task-actions d-flex gap-2 mt-3">
                            @if($task->completion_image)
                            <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewProofModal{{ $task->taskID }}">
                                <i class="fas fa-image me-1"></i>View Proof
                            </button>
                            @endif
                            
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $task->taskID }}">
                                <i class="fas fa-check me-1"></i>Approve
                            </button>
                            
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $task->taskID }}">
                                <i class="fas fa-times me-1"></i>Reject
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if($task->task_status == 'awaiting_approval')
        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal{{ $task->taskID }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Approve Task Completion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if($task->completion_image)
                            <div class="col-md-6">
                                <h6>Completion Proof:</h6>
                                <img src="{{ asset('storage/' . $task->completion_image) }}" alt="Completion Proof" class="img-fluid rounded mb-3" style="max-height: 300px;">
                            </div>
                            @endif
                            
                            <div class="{{ $task->completion_image ? 'col-md-6' : 'col-12' }}">
                                <h6>Task Details:</h6>
                                <p><strong>Task:</strong> {{ $task->task_type }}</p>
                                <p><strong>Location:</strong> {{ $task->report->room->house->house_address }}</p>
                                <p><strong>Room:</strong> {{ $task->report->room->room_type }}</p>
                                <p><strong>Item:</strong> {{ $task->report->item->item_name }}</p>
                                
                                @if($task->completion_notes)
                                <div class="mt-3">
                                    <h6>Contractor Notes:</h6>
                                    <div class="alert alert-info">
                                        {{ $task->completion_notes }}
                                    </div>
                                </div>
                                @endif
                                
                                @if($task->submitted_at)
                                <p class="text-muted"><small>Submitted: {{ $task->submitted_at->format('M d, Y h:i A') }}</small></p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Are you sure you want to approve this task as completed?</strong>
                            <br><small>This action will mark the task as completed and notify the contractor.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('landlord.tasks.approve', $task->taskID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Approve Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $task->taskID }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Task Completion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('landlord.tasks.reject', $task->taskID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rejection_reason{{ $task->taskID }}" class="form-label">Reason for Rejection *</label>
                                <textarea class="form-control" id="rejection_reason{{ $task->taskID }}" name="rejection_reason" rows="3" required placeholder="Please explain why you're rejecting this completion..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Proof Modal -->
        @if($task->completion_image)
        <div class="modal fade" id="viewProofModal{{ $task->taskID }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Completion Proof</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $task->completion_image) }}" alt="Completion Proof" class="img-fluid rounded" style="max-height: 400px;">
                        @if($task->completion_notes)
                        <div class="mt-3">
                            <h6>Contractor Notes:</h6>
                            <p class="text-muted">{{ $task->completion_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <h4 class="empty-state-title">No tasks found</h4>
        <p class="empty-state-description">There are no maintenance tasks to display at the moment.</p>
        <div class="empty-state-action">
            <a href="{{ route('landlord.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create New Task
            </a>
        </div>
    </div>
@endif

<style>
/* Enhanced Task Grid */
.tasks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    padding: 1rem 0;
}

/* Enhanced Task Card */
.task-card-wrapper {
    perspective: 1000px;
}

.task-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    border: 1px solid #f1f5f9;
}

.task-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.task-card:hover {
    transform: translateY(-10px) rotateX(5deg);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

/* Task Header */
.task-header {
    padding: 1.5rem 1.5rem 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
}

.task-info {
    flex: 1;
}

.task-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.task-location {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.task-details {
    color: #94a3b8;
    font-size: 0.85rem;
    margin: 0;
}

.task-status {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.status-pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.status-progress {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.status-completed {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.status-awaiting {
    background-color: #fbbf24;
    color: #92400e;
}

/* Contractor Section */
.contractor-section {
    padding: 0 1.5rem 1rem;
}

.contractor-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 15px;
    border: 1px solid #e2e8f0;
}

.contractor-avatar {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.contractor-details {
    flex: 1;
}

.contractor-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.contractor-email {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}

/* Task Footer */
.task-footer {
    padding: 1rem 1.5rem 1.5rem;
    background: white;
}

.task-meta {
    display: flex;
    justify-content: center;
}

.meta-item-single {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    min-width: 200px;
    justify-content: center;
}

.meta-icon {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.meta-content {
    flex: 1;
}

.meta-label {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.meta-value {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
}

/* Enhanced Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid #f1f5f9;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2.5rem;
    color: #94a3b8;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.empty-state-description {
    font-size: 1rem;
    color: #64748b;
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.empty-state-action .btn {
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.empty-state-action .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .tasks-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .task-card {
        margin: 0 1rem;
    }
    
    .task-header {
        padding: 1rem;
    }
    
    .task-title {
        font-size: 1.1rem;
    }
    
    .contractor-section {
        padding: 0 1rem 1rem;
    }
    
    .task-footer {
        padding: 1rem;
    }
    
    .meta-item-single {
        padding: 0.5rem 1rem;
        min-width: auto;
    }
}
</style>

<script>
// Add this script at the end of the file, before the closing </style> tag
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions with loading states
    const forms = document.querySelectorAll('form[action*="approve"], form[action*="reject"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
            }
        });
    });
    
    // Handle modal close events
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            // Reset any form states when modal is closed
            const forms = modal.querySelectorAll('form');
            forms.forEach(form => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (submitBtn.textContent.includes('Approve')) {
                        submitBtn.innerHTML = 'Approve Task';
                    } else if (submitBtn.textContent.includes('Reject')) {
                        submitBtn.innerHTML = 'Reject Task';
                    }
                }
            });
        });
    });
});
</script>