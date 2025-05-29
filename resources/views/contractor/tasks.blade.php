@extends('ui.layout')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">My Tasks</h4>
            <p class="text-muted mb-0">View and manage your assigned maintenance tasks</p>
        </div>
        <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
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

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="icon-box bg-warning-light me-3">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <h5 class="mb-0">Pending</h5>
            </div>
            <h2 class="mb-3">{{ $tasks->where('task_status', 'pending')->count() }}</h2>
            <p class="text-muted mb-0">Tasks awaiting completion</p>
        </div>
        @if($tasks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date Assigned</th>
                            <th>Property</th>
                            <th>Room</th>
                            <th>Item</th>
                            <th>Issue Description</th>
                            <th>Task Type</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->created_at->format('M d, Y') }}</td>
                                <td>{{ $task->report->room->house->house_address }}</td>
                                <td>{{ $task->report->room->room_type }}</td>
                                <td>{{ $task->report->item->item_name }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($task->report->report_desc, 50) }}</td>
                                <td>{{ $task->task_type }}</td>
                                <td>
                                    @if($task->task_status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($task->task_status == 'in_progress')
                                        <span class="badge bg-info">In Progress</span>
                                    @elseif($task->task_status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $task->report->report_image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-image"></i> View
                                    </a>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $task->taskID }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $task->taskID }}">
                                            <li>
                                                <form action="{{ route('contractor.tasks.update-status', $task->taskID) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="in_progress">
                                                    <button type="submit" class="dropdown-item">Mark as In Progress</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('contractor.tasks.update-status', $task->taskID) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item">Mark as Completed</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                <h5>No Tasks Assigned</h5>
                <p class="text-muted">You don't have any maintenance tasks assigned yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection