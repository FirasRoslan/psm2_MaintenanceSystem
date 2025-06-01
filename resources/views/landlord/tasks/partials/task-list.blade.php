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
                            @elseif($task->task_status == 'completed') status-completed
                            @endif">
                            @if($task->task_status == 'pending') 
                                <i class="fas fa-clock me-1"></i>Pending
                            @elseif($task->task_status == 'in_progress') 
                                <i class="fas fa-tools me-1"></i>In Progress
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

                <!-- Progress Section -->
                <div class="progress-section">
                    <div class="progress-circle-container">
                        <div class="progress-circle">
                            <svg class="progress-ring" width="80" height="80">
                                <circle
                                    stroke="#e2e8f0"
                                    stroke-width="6"
                                    fill="transparent"
                                    r="34"
                                    cx="40"
                                    cy="40"/>
                                <circle
                                    stroke="@if($task->task_status == 'completed') #10b981 @elseif($task->task_status == 'in_progress') #3b82f6 @else #6b7280 @endif"
                                    stroke-width="6"
                                    fill="transparent"
                                    r="34"
                                    cx="40"
                                    cy="40"
                                    stroke-dasharray="{{ 213.6 * (($task->progress_percentage ?? 0) / 100) }} 213.6"
                                    stroke-dashoffset="0"
                                    transform="rotate(-90 40 40)"
                                    class="progress-stroke"/>
                            </svg>
                            <div class="progress-text">
                                <span class="progress-percentage">{{ $task->progress_percentage ?? 0 }}%</span>
                                <span class="progress-label">Complete</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Info Footer -->
                <div class="task-footer">
                    <div class="task-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt meta-icon"></i>
                            <div class="meta-content">
                                <span class="meta-label">Assigned</span>
                                <span class="meta-value">{{ $task->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-layer-group meta-icon"></i>
                            <div class="meta-content">
                                <span class="meta-label">Phases</span>
                                <span class="meta-value">{{ $task->phases->count() }}/{{ $task->phases->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

/* Progress Section */
.progress-section {
    padding: 1.5rem;
    display: flex;
    justify-content: center;
    background: #fafbfc;
}

.progress-circle-container {
    position: relative;
}

.progress-circle {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-ring {
    transform: rotate(-90deg);
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

.progress-stroke {
    transition: stroke-dasharray 0.6s ease-in-out;
    stroke-linecap: round;
}

.progress-text {
    position: absolute;
    text-align: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.progress-percentage {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.progress-label {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
}

/* Task Footer */
.task-footer {
    padding: 1rem 1.5rem 1.5rem;
    background: white;
}

.task-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
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
    
    .task-card:hover {
        transform: translateY(-5px);
    }
    
    .task-header {
        padding: 1rem;
    }
    
    .task-status {
        position: static;
        margin-top: 1rem;
    }
    
    .contractor-section {
        padding: 0 1rem 1rem;
    }
    
    .progress-section {
        padding: 1rem;
    }
    
    .task-footer {
        padding: 1rem;
    }
    
    .task-meta {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .empty-state {
        padding: 2rem 1rem;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
}
</style>