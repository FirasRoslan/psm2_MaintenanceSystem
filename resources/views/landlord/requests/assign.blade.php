@extends('ui.layout')

@section('title', 'Assign Task to Contractor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Assign Task to Contractor</h4>
            <p class="text-muted mb-0">Assign this maintenance request to a contractor</p>
        </div>
        <a href="{{ route('landlord.requests.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to Requests
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Maintenance Request Details</h5>
                </div>
                <div class="card-body">
                    <div class="request-details">
                        <div class="status-badge mb-4">
                            @if($report->report_status == 'Pending')
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                            @elseif($report->report_status == 'In Progress')
                                <span class="badge bg-info rounded-pill px-3 py-2">
                                    <i class="fas fa-tools me-1"></i> In Progress
                                </span>
                            @elseif($report->report_status == 'Completed')
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Completed
                                </span>
                            @elseif($report->report_status == 'Rejected')
                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> Rejected
                                </span>
                            @endif
                        </div>
                        
                        <div class="detail-item mb-3">
                            <div class="d-flex">
                                <div class="icon-box bg-primary-light me-3">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted mb-0">Property</label>
                                    <p class="mb-0 fw-medium">{{ $report->room->house->house_address }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <div class="d-flex">
                                <div class="icon-box bg-info-light me-3">
                                    <i class="fas fa-door-open text-info"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted mb-0">Room</label>
                                    <p class="mb-0 fw-medium">{{ $report->room->room_type }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <div class="d-flex">
                                <div class="icon-box bg-warning-light me-3">
                                    <i class="fas fa-couch text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted mb-0">Item</label>
                                    <p class="mb-0 fw-medium">{{ $report->item->item_name }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <div class="d-flex">
                                <div class="icon-box bg-success-light me-3">
                                    <i class="fas fa-user text-success"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted mb-0">Reported By</label>
                                    <p class="mb-0 fw-medium">{{ $report->user->name }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-3">
                            <div class="d-flex">
                                <div class="icon-box bg-secondary-light me-3">
                                    <i class="fas fa-calendar-alt text-secondary"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted mb-0">Date Reported</label>
                                    <p class="mb-0 fw-medium">{{ $report->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-item mb-4">
                            <label class="form-label text-muted mb-2">Description</label>
                            <div class="description-box p-3 rounded-3 bg-light">
                                {{ $report->report_desc }}
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <label class="form-label text-muted mb-2">Image</label>
                            <div class="image-preview mb-3">
                                <img src="{{ asset('storage/' . $report->report_image) }}" alt="Report Image" class="img-fluid rounded-3" style="max-height: 200px;">
                            </div>
                            <a href="{{ asset('storage/' . $report->report_image) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-external-link-alt me-1"></i> Open Full Image
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Assign to Contractor</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.requests.store-task', $report->reportID) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="userID" class="form-label">Select Contractor</label>
                            <div class="contractor-select-wrapper">
                                <select name="userID" id="userID" class="form-select @error('userID') is-invalid @enderror" required>
                                    <option value="">-- Select Contractor --</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->userID }}">{{ $contractor->name }}</option>
                                    @endforeach
                                </select>
                                <div class="select-icon">
                                    <i class="fas fa-hard-hat"></i>
                                </div>
                            </div>
                            @error('userID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Select a contractor who specializes in this type of maintenance
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="task_type" class="form-label">Task Type</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-tasks text-primary"></i>
                                </span>
                                <input type="text" name="task_type" id="task_type" class="form-control border-start-0 @error('task_type') is-invalid @enderror" placeholder="e.g., Plumbing Repair, Electrical Fix" required>
                            </div>
                            @error('task_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Specify the type of task to be performed
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="task_priority" class="form-label">Priority Level</label>
                            <div class="priority-selector d-flex">
                                <div class="form-check form-check-inline flex-fill">
                                    <input class="form-check-input" type="radio" name="task_priority" id="priorityLow" value="Low" checked>
                                    <label class="form-check-label priority-label low" for="priorityLow">
                                        <i class="fas fa-arrow-down me-1"></i> Low
                                    </label>
                                </div>
                                <div class="form-check form-check-inline flex-fill">
                                    <input class="form-check-input" type="radio" name="task_priority" id="priorityMedium" value="Medium">
                                    <label class="form-check-label priority-label medium" for="priorityMedium">
                                        <i class="fas fa-minus me-1"></i> Medium
                                    </label>
                                </div>
                                <div class="form-check form-check-inline flex-fill">
                                    <input class="form-check-input" type="radio" name="task_priority" id="priorityHigh" value="High">
                                    <label class="form-check-label priority-label high" for="priorityHigh">
                                        <i class="fas fa-arrow-up me-1"></i> High
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="task_notes" class="form-label">Additional Notes (Optional)</label>
                            <textarea name="task_notes" id="task_notes" class="form-control" rows="3" placeholder="Add any specific instructions or details for the contractor..."></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <i class="fas fa-user-plus me-2"></i>Assign Task to Contractor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .fw-medium {
        font-weight: 500;
    }
    
    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .bg-secondary-light {
        background-color: rgba(108, 117, 125, 0.1);
    }
    
    .description-box {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
    }
    
    .contractor-select-wrapper {
        position: relative;
    }
    
    .select-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #0d6efd;
    }
    
    .priority-selector .form-check {
        padding: 0;
        margin-right: 10px;
    }
    
    .priority-selector .form-check:last-child {
        margin-right: 0;
    }
    
    .priority-selector .form-check-input {
        display: none;
    }
    
    .priority-label {
        display: block;
        padding: 8px;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #dee2e6;
    }
    
    .priority-label.low {
        color: #198754;
    }
    
    .priority-label.medium {
        color: #fd7e14;
    }
    
    .priority-label.high {
        color: #dc3545;
    }
    
    .form-check-input:checked + .priority-label.low {
        background-color: #198754;
        color: white;
        border-color: #198754;
    }
    
    .form-check-input:checked + .priority-label.medium {
        background-color: #fd7e14;
        color: white;
        border-color: #fd7e14;
    }
    
    .form-check-input:checked + .priority-label.high {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
</style>
@endpush
@endsection