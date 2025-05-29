@extends('ui.layout')

@section('title', 'Assign Task to Contractor')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <h1 class="dashboard-title mb-2">Assign Task to Contractor</h1>
                    <p class="dashboard-subtitle mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Assign maintenance request to a qualified contractor
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="dashboard-actions">
                    <a href="{{ route('landlord.requests.index') }}" class="btn btn-modern-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Requests
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Request Details Card -->
        <div class="col-lg-6">
            <div class="modern-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Request Details
                    </h5>
                </div>
                
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">Current Status</span>
                        <span class="status-badge pending">{{ $report->report_status }}</span>
                    </div>

                    <!-- Property Information -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Property</span>
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

                    <!-- Item and Reporter -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Item</span>
                                    <span class="info-value">{{ $report->item->item_name }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Reported by</span>
                                    <span class="info-value">{{ $report->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date Reported -->
                    <div class="info-item mb-4">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Date Reported</span>
                            <span class="info-value">{{ $report->created_at->format('M d, Y \\a\\t h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="mb-2">Description</h6>
                        <div class="description-box">
                            <p class="mb-0">{{ $report->report_desc }}</p>
                        </div>
                    </div>

                    <!-- Image -->
                    @if($report->report_image)
                    <div>
                        <h6 class="mb-2">Attached Image</h6>
                        <img src="{{ asset('storage/' . $report->report_image) }}" 
                             alt="Report Image" 
                             class="img-fluid rounded"
                             style="max-height: 200px; cursor: pointer;"
                             data-bs-toggle="modal" 
                             data-bs-target="#imageModal">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assignment Form Card -->
        <div class="col-lg-6">
            <div class="modern-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>Assign to Contractor
                    </h5>
                </div>

                <form action="{{ route('landlord.requests.assign-task', $report->reportID) }}" method="POST">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Contractor Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user-tie me-2"></i>Select Contractor
                            </label>
                            <select name="userID" required class="form-select">
                                <option value="">Choose a contractor...</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->userID }}">{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Task Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tasks me-2"></i>Task Type
                            </label>
                            <select name="task_type" required class="form-select">
                                <option value="">Select task type...</option>
                                <option value="repair">Repair</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="replacement">Replacement</option>
                                <option value="inspection">Inspection</option>
                                <option value="cleaning">Cleaning</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sticky-note me-2"></i>Additional Notes
                            </label>
                            <textarea name="notes" rows="4" 
                                      placeholder="Add any specific instructions or requirements for the contractor..."
                                      class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent">
                        <button type="submit" class="btn btn-modern-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Assign Task to Contractor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
@if($report->report_image)
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Report Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ asset('storage/' . $report->report_image) }}" 
                     alt="Report Image" 
                     class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>
@endif
@endsection