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
                                    stroke-dasharray="{{ 213.6 * ($task->progress_percentage / 100) }} 213.6"
                                    stroke-dashoffset="0"
                                    transform="rotate(-90 40 40)"
                                    class="progress-stroke"/>
                            </svg>
                            <div class="progress-text">
                                <span class="progress-percentage">{{ $task->progress_percentage }}%</span>
                                <span class="progress-label">Complete</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phase Timeline -->
                @if($task->phases->count() > 0)
                <div class="phase-section">
                    <h6 class="phase-title">Phase Progress</h6>
                    <div class="phase-timeline">
                        @foreach($task->phases as $phase)
                        <div class="phase-item">
                            <div class="phase-indicator 
                                @if($phase->phase_status == 'completed') phase-completed
                                @elseif($phase->phase_status == 'in_progress') phase-active
                                @else phase-pending
                                @endif">
                                @if($phase->phase_status == 'completed')
                                    <i class="fas fa-check"></i>
                                @elseif($phase->phase_status == 'in_progress')
                                    <i class="fas fa-play"></i>
                                @else
                                    {{ $phase->arrangement_number }}
                                @endif
                            </div>
                            <div class="phase-content">
                                <p class="phase-name">Phase {{ $phase->arrangement_number }}</p>
                                <p class="phase-status-text">
                                    @if($phase->phase_status == 'completed')
                                        Completed {{ $phase->end_timestamp ? $phase->end_timestamp->format('M d, Y') : '' }}
                                    @elseif($phase->phase_status == 'in_progress')
                                        Started {{ $phase->start_timestamp ? $phase->start_timestamp->format('M d, Y') : '' }}
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="no-phases">
                    <div class="no-phases-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <p class="no-phases-text">No phases defined yet</p>
                </div>
                @endif

                <!-- Task Footer -->
                <div class="task-footer">
                    <div class="task-stats">
                        <div class="stat-item">
                            <span class="stat-label">Assigned</span>
                            <span class="stat-value">{{ $task->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Phases</span>
                            <span class="stat-value">{{ $task->phases->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-content">
            <div class="empty-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <h5 class="empty-title">No Tasks Found</h5>
            <p class="empty-description">There are no tasks in this category yet. Tasks will appear here once they are assigned to contractors.</p>
            <a href="{{ route('landlord.requests.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Assign New Task
            </a>
        </div>
    </div>
@endif

@push('styles')
<style>
    /* Tasks Grid */
    .tasks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
        padding: 1rem 0;
    }
    
    .task-card-wrapper {
        height: 100%;
    }
    
    .task-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        border-color: #e2e8f0;
    }
    
    /* Task Header */
    .task-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .task-info {
        margin-bottom: 1rem;
    }
    
    .task-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
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
        display: flex;
        justify-content: flex-end;
    }
    
    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
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
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .contractor-info {
        display: flex;
        align-items: center;
    }
    
    .contractor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        margin-right: 1rem;
    }
    
    .contractor-name {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    
    .contractor-email {
        color: #64748b;
        font-size: 0.85rem;
        margin: 0;
    }
    
    /* Progress Section */
    .progress-section {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .progress-circle-container {
        display: flex;
        justify-content: center;
    }
    
    .progress-circle {
        position: relative;
        display: inline-block;
    }
    
    .progress-ring {
        width: 80px;
        height: 80px;
        transform: rotate(-90deg);
    }
    
    .progress-stroke {
        transition: stroke-dasharray 0.8s ease;
    }
    
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    
    .progress-percentage {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
    }
    
    .progress-label {
        display: block;
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Phase Section */
    .phase-section {
        padding: 1.5rem;
        flex-grow: 1;
    }
    
    .phase-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    
    .phase-timeline {
        position: relative;
    }
    
    .phase-timeline::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #e2e8f0 0%, #f1f5f9 100%);
    }
    
    .phase-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .phase-item:last-child {
        margin-bottom: 0;
    }
    
    .phase-indicator {
        position: absolute;
        left: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .phase-completed {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .phase-active {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        animation: pulse 2s infinite;
    }
    
    .phase-pending {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }
    
    .phase-content {
        flex-grow: 1;
    }
    
    .phase-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    
    .phase-status-text {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
    }
    
    /* No Phases */
    .no-phases {
        padding: 2rem 1.5rem;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .no-phases-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: #94a3b8;
    }
    
    .no-phases-text {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }
    
    /* Task Footer */
    .task-footer {
        padding: 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        margin-top: auto;
    }
    
    .task-stats {
        display: flex;
        justify-content: space-between;
    }
    
    .stat-item {
        text-align: center;
        flex: 1;
    }
    
    .stat-label {
        display: block;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .stat-value {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Empty State */
    .empty-state {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
        padding: 2rem;
    }
    
    .empty-state-content {
        text-align: center;
        max-width: 400px;
    }
    
    .empty-icon {
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
    
    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 1rem;
    }
    
    .empty-description {
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    /* Button Styling */
    .btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 0.75rem 1.5rem;
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
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .tasks-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .task-header,
        .contractor-section,
        .progress-section,
        .phase-section,
        .task-footer {
            padding: 1rem;
        }
        
        .phase-item {
            padding-left: 40px;
        }
        
        .phase-indicator {
            width: 30px;
            height: 30px;
            font-size: 0.7rem;
        }
        
        .phase-timeline::before {
            left: 15px;
        }
    }
</style>
@endpush