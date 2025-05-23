@extends('ui.layout')

@section('title', 'Maintenance Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Maintenance Requests</h4>
            <p class="text-muted mb-0">View and manage maintenance requests from tenants</p>
        </div>
        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary rounded-pill">
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

    <!-- Status filter tabs -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-pills nav-fill status-filter p-2">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-status="all">
                        <i class="fas fa-list-ul me-2"></i>All Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="Pending">
                        <i class="fas fa-clock me-2"></i>Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="In Progress">
                        <i class="fas fa-tools me-2"></i>In Progress
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="Completed">
                        <i class="fas fa-check-circle me-2"></i>Completed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-status="Rejected">
                        <i class="fas fa-times-circle me-2"></i>Rejected
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle maintenance-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Tenant</th>
                                <th>Property</th>
                                <th>Room</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="request-row" data-status="{{ $report->report_status }}">
                                    <td>{{ $report->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-primary text-white">
                                                {{ substr($report->user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $report->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $report->room->house->house_address }}</td>
                                    <td>{{ $report->room->room_type }}</td>
                                    <td>{{ $report->item->item_name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($report->report_desc, 50) }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $report->report_image) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-image me-1"></i> View
                                        </a>
                                    </td>
                                    <td>
                                        <div class="action-buttons text-center">
                                            <!-- Status update buttons -->
                                            <div class="btn-group mb-2 w-100">
                                                @if($report->report_status != 'In Progress')
                                                <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="In Progress">
                                                    <button type="submit" class="btn btn-sm btn-info rounded-start" data-bs-toggle="tooltip" title="Mark as In Progress">
                                                        <i class="fas fa-tools"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                @if($report->report_status != 'Completed')
                                                <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Completed">
                                                    <button type="submit" class="btn btn-sm btn-success {{ $report->report_status != 'In Progress' ? 'rounded-start' : '' }}" data-bs-toggle="tooltip" title="Mark as Completed">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                @if($report->report_status != 'Rejected')
                                                <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-end" data-bs-toggle="tooltip" title="Reject Request">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                            
                                            <!-- Assign button -->
                                            <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="btn btn-sm btn-primary rounded-pill w-100" data-bs-toggle="tooltip" title="Assign to Contractor">
                                                <i class="fas fa-user-hard-hat me-1"></i> Assign
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h5>No Maintenance Requests</h5>
                    <p class="text-muted">There are no maintenance requests from tenants at this time.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .status-filter .nav-link {
        border-radius: 0.5rem;
        color: #6c757d;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    
    .status-filter .nav-link:hover {
        background-color: #f8f9fa;
    }
    
    .status-filter .nav-link.active {
        background-color: #0ea5e9;
        color: white;
    }
    
    .maintenance-table th {
        font-weight: 600;
        color: #495057;
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
    
    .action-buttons .btn {
        transition: all 0.2s;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    // Status filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterLinks = document.querySelectorAll('.status-filter .nav-link');
        const requestRows = document.querySelectorAll('.request-row');
        
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                filterLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                const status = this.getAttribute('data-status');
                
                // Show/hide rows based on status
                requestRows.forEach(row => {
                    if (status === 'all' || row.getAttribute('data-status') === status) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection