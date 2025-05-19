@extends('ui.layout')

@section('title', 'Contractor Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Contractor Details</h4>
            <p class="text-muted mb-0">View details about this contractor</p>
        </div>
        <a href="{{ route('landlord.contractors.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Contractors
        </a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-0">
                    <div class="bg-gradient-primary text-white p-4 rounded-top-4">
                        <div class="text-center">
                            <div class="avatar-circle mx-auto mb-3">
                                <span class="initials">{{ substr($contractor->name, 0, 1) }}</span>
                            </div>
                            <h4 class="mb-1">{{ $contractor->name }}</h4>
                            <p class="mb-0 opacity-75">{{ $contractor->email }}</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-semibold small mb-2">Contact Information</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $contractor->email }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $contractor->phone }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-semibold small mb-2">Maintenance Scope</h6>
                            <p class="mb-0">{{ $relationship->maintenance_scope }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-semibold small mb-2">Specialization</h6>
                            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $relationship->specialization }}</span>
                        </div>
                        
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold small mb-2">Approval Status</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success rounded-pill px-3 py-2">Approved</span>
                                <span class="ms-2 small text-muted">{{ $relationship->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Assigned Tasks</h5>
                    <span class="badge bg-primary rounded-pill">{{ $tasks->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Task</th>
                                        <th class="border-0">Property</th>
                                        <th class="border-0">Room</th>
                                        <th class="border-0">Item</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Date Assigned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="task-status-indicator me-3 
                                                    @if($task->task_status == 'Pending') bg-warning 
                                                    @elseif($task->task_status == 'In Progress') bg-info 
                                                    @elseif($task->task_status == 'Completed') bg-success 
                                                    @endif">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $task->task_type }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $task->report->room->house->house_address }}</td>
                                        <td>{{ $task->report->room->room_type }}</td>
                                        <td>{{ $task->report->item->item_name }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($task->task_status == 'Pending') bg-warning 
                                                @elseif($task->task_status == 'In Progress') bg-info 
                                                @elseif($task->task_status == 'Completed') bg-success 
                                                @endif rounded-pill px-3">
                                                {{ $task->task_status }}
                                            </span>
                                        </td>
                                        <td>{{ $task->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <h5>No Tasks Assigned</h5>
                            <p class="text-muted">You haven't assigned any tasks to this contractor yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Modern styling */
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .rounded-top-4 {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
    }
    
    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: rgba(255, 255, 255, 0.2);
        text-align: center;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 255, 255, 0.5);
    }

    .initials {
        font-size: 40px;
        line-height: 40px;
        color: #fff;
        font-weight: bold;
    }
    
    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0ea5e9;
    }
    
    .task-status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
        color: #adb5bd;
    }
</style>
@endpush
@endsection