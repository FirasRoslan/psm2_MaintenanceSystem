@extends('ui.layout')

@section('title', 'Assign Task to Contractor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Assign Task to Contractor</h4>
            <p class="text-muted mb-0">Assign this maintenance request to a contractor</p>
        </div>
        <a href="{{ route('landlord.requests.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Requests
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Maintenance Request Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Property</label>
                        <p class="mb-1">{{ $report->room->house->house_address }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Room</label>
                        <p class="mb-1">{{ $report->room->room_type }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Item</label>
                        <p class="mb-1">{{ $report->item->item_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Description</label>
                        <p class="mb-1">{{ $report->report_desc }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Reported By</label>
                        <p class="mb-1">{{ $report->user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Status</label>
                        <p class="mb-1">
                            @if($report->report_status == 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($report->report_status == 'In Progress')
                                <span class="badge bg-info">In Progress</span>
                            @elseif($report->report_status == 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($report->report_status == 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Image</label>
                        <div>
                            <a href="{{ asset('storage/' . $report->report_image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-image me-1"></i> View Image
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Assign to Contractor</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.requests.store-task', $report->reportID) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="userID" class="form-label">Select Contractor</label>
                            <select name="userID" id="userID" class="form-select @error('userID') is-invalid @enderror" required>
                                <option value="">-- Select Contractor --</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->userID }}">{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                            @error('userID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="task_type" class="form-label">Task Type</label>
                            <input type="text" name="task_type" id="task_type" class="form-control @error('task_type') is-invalid @enderror" placeholder="e.g., Plumbing Repair, Electrical Fix" required>
                            @error('task_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Assign Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection