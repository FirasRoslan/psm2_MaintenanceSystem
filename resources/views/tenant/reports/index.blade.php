@extends('ui.layout')

@section('title', 'My Maintenance Reports')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section with Card Design -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="page-title-section">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tenant.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">My Reports</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-clipboard-list me-3"></i>My Maintenance Reports
                    </h1>
                    <p class="page-subtitle mb-0">View and track your maintenance requests</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('tenant.reports.create') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Submit Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg text-success"></i>
            </div>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Reports Summary Cards with Charts -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box bg-primary bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-clipboard-list text-primary fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">{{ $reports->count() }}</h3>
                            <p class="text-muted mb-0 fw-medium">Total Reports</p>
                            <small class="text-primary"><i class="fas fa-chart-line me-1"></i>All time</small>
                        </div>
                        <div class="position-absolute bottom-0 end-0 opacity-10">
                            <i class="fas fa-clipboard-list" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box bg-warning bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-clock text-warning fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">{{ $reports->where('report_status', 'Pending')->count() }}</h3>
                            <p class="text-muted mb-0 fw-medium">Pending</p>
                            <small class="text-warning"><i class="fas fa-hourglass-half me-1"></i>Awaiting review</small>
                        </div>
                        <div class="position-absolute bottom-0 end-0 opacity-10">
                            <i class="fas fa-clock" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box bg-info bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-tools text-info fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">{{ $reports->where('report_status', 'In Progress')->count() }}</h3>
                            <p class="text-muted mb-0 fw-medium">In Progress</p>
                            <small class="text-info"><i class="fas fa-wrench me-1"></i>Being fixed</small>
                        </div>
                        <div class="position-absolute bottom-0 end-0 opacity-10">
                            <i class="fas fa-tools" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box bg-success bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">{{ $reports->where('report_status', 'Completed')->count() }}</h3>
                            <p class="text-muted mb-0 fw-medium">Completed</p>
                            <small class="text-success"><i class="fas fa-check me-1"></i>Resolved</small>
                        </div>
                        <div class="position-absolute bottom-0 end-0 opacity-10">
                            <i class="fas fa-check-circle" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reports Status Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Reports Status Distribution</h5>
                    <div class="position-relative">
                        <canvas id="reportsStatusChart" width="200" height="200"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">Pending</span>
                            </div>
                            <span class="fw-bold">{{ $reports->where('report_status', 'Pending')->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">In Progress</span>
                            </div>
                            <span class="fw-bold">{{ $reports->where('report_status', 'In Progress')->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <span class="text-muted">Completed</span>
                            </div>
                            <span class="fw-bold">{{ $reports->where('report_status', 'Completed')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white p-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">All Reports</h5>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>Filter by Status
                        </button>
                        <ul class="dropdown-menu shadow border-0 rounded-3" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="#" onclick="filterReports('all')">All Reports</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterReports('Pending')">Pending</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterReports('In Progress')">In Progress</a></li>
                            <li><a class="dropdown-item" href="#" onclick="filterReports('Completed')">Completed</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 fw-bold text-muted">Report Details</th>
                                <th class="border-0 px-4 py-3 fw-bold text-muted">Property</th>
                                <th class="border-0 px-4 py-3 fw-bold text-muted">Date</th>
                                <th class="border-0 px-4 py-3 fw-bold text-muted">Status</th>
                                <th class="border-0 px-4 py-3 fw-bold text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="report-row" data-status="{{ $report->report_status }}">
                                    <td class="px-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-light p-2 rounded-2 me-3">
                                                <i class="fas fa-tools text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ Str::limit($report->report_description, 50) }}</h6>
                                                <small class="text-muted">Report #{{ $report->reportID }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div>
                                            <span class="fw-medium">{{ Str::limit($report->room->house->house_address, 30) }}</span><br>
                                            <small class="text-muted">{{ $report->room->room_type }}</small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="fw-medium">{{ $report->created_at->format('M d, Y') }}</span><br>
                                        <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="badge 
                                            @if($report->report_status === 'Pending') bg-warning
                                            @elseif($report->report_status === 'In Progress') bg-info
                                            @else bg-success
                                            @endif bg-opacity-10 text-{{ $report->report_status === 'Pending' ? 'warning' : ($report->report_status === 'In Progress' ? 'info' : 'success') }} px-3 py-2 rounded-pill">
                                            <i class="fas 
                                                @if($report->report_status === 'Pending') fa-clock
                                                @elseif($report->report_status === 'In Progress') fa-tools
                                                @else fa-check-circle
                                                @endif me-1"></i>
                                            {{ $report->report_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#reportModal"
                                                data-report-id="{{ $report->reportID }}"
                                                data-report-date="{{ $report->created_at->format('M d, Y') }}"
                                                data-report-property="{{ $report->room->house->house_address }}"
                                                data-report-room="{{ $report->room->room_type }}"
                                                data-report-item="{{ $report->item->item_name }}"
                                                data-report-image="{{ $report->report_image }}"
                                                data-report-description="{{ $report->report_description }}"
                                                data-report-status="{{ $report->report_status }}">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="icon-box bg-light p-4 rounded-3 d-inline-flex mb-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No Maintenance Reports Yet</h5>
                    <p class="text-muted mb-4">You haven't submitted any maintenance reports yet.</p>
                    <a href="{{ route('tenant.assigned-houses') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-home me-2"></i>View My Properties
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Report Details Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold" id="reportModalLabel">Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="reportDetails">
                    <!-- Report details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}

.report-row {
    transition: all 0.2s ease;
}

/* Page Header Card Design */
.page-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(99, 102, 241, 0.1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--primary-dark);
}

.btn-modern-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-actions {
        margin-top: 1rem;
    }
    
    .page-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reports Status Pie Chart
    const ctx = document.getElementById('reportsStatusChart').getContext('2d');
    const pendingCount = {{ $reports->where('report_status', 'Pending')->count() }};
    const inProgressCount = {{ $reports->where('report_status', 'In Progress')->count() }};
    const completedCount = {{ $reports->where('report_status', 'Completed')->count() }};
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: [pendingCount, inProgressCount, completedCount],
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 202, 240, 0.8)',
                    'rgba(25, 135, 84, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(13, 202, 240, 1)',
                    'rgba(25, 135, 84, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
    
    // Report modal functionality
    const reportModal = document.getElementById('reportModal');
    reportModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const reportId = button.getAttribute('data-report-id');
        const reportDate = button.getAttribute('data-report-date');
        const reportProperty = button.getAttribute('data-report-property');
        const reportRoom = button.getAttribute('data-report-room');
        const reportItem = button.getAttribute('data-report-item');
        const reportImage = button.getAttribute('data-report-image');
        const reportDescription = button.getAttribute('data-report-description');
        const reportStatus = button.getAttribute('data-report-status');
        
        const statusClass = reportStatus === 'Pending' ? 'warning' : (reportStatus === 'In Progress' ? 'info' : 'success');
        const statusIcon = reportStatus === 'Pending' ? 'clock' : (reportStatus === 'In Progress' ? 'tools' : 'check-circle');
        
        document.getElementById('reportDetails').innerHTML = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Report ID</label>
                    <p class="fw-medium">#${reportId}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Date Submitted</label>
                    <p class="fw-medium">${reportDate}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Property</label>
                    <p class="fw-medium">${reportProperty}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Room</label>
                    <p class="fw-medium">${reportRoom}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Item/Area</label>
                    <p class="fw-medium">${reportItem}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-muted">Status</label>
                    <p><span class="badge bg-${statusClass} bg-opacity-10 text-${statusClass} px-3 py-2 rounded-pill">
                        <i class="fas fa-${statusIcon} me-1"></i>${reportStatus}
                    </span></p>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted">Description</label>
                    <div class="bg-light p-3 rounded-3">
                        <p class="mb-0">${reportDescription}</p>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Submitted Image</label>
                    <div class="mt-2">
                        <img src="/storage/${reportImage}" alt="Report Image" class="img-fluid rounded-3 shadow-sm" style="max-height: 300px; max-width: 100%;">
                    </div>
                </div>
            </div>
        `;
    });
});

// Filter reports function
function filterReports(status) {
    const rows = document.querySelectorAll('.report-row');
    rows.forEach(row => {
        if (status === 'all' || row.getAttribute('data-status') === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection