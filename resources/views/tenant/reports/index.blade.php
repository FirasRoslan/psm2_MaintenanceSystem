@extends('ui.layout')

@section('title', 'My Maintenance Reports')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">My Maintenance Reports</h4>
            <p class="text-muted mb-0">View and track your maintenance requests</p>
        </div>
        <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-primary rounded-pill">
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

    <!-- Reports Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary-light me-3">
                            <i class="fas fa-clipboard-list text-primary"></i>
                        </div>
                        <h5 class="mb-0">Total</h5>
                    </div>
                    <h2 class="mb-3">{{ $reports->count() }}</h2>
                    <p class="text-muted mb-0">Total maintenance reports</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-light me-3">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <h5 class="mb-0">Pending</h5>
                    </div>
                    <h2 class="mb-3">{{ $reports->where('report_status', 'Pending')->count() }}</h2>
                    <p class="text-muted mb-0">Awaiting review</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-info-light me-3">
                            <i class="fas fa-tools text-info"></i>
                        </div>
                        <h5 class="mb-0">In Progress</h5>
                    </div>
                    <h2 class="mb-3">{{ $reports->where('report_status', 'In Progress')->count() }}</h2>
                    <p class="text-muted mb-0">Currently being fixed</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-light me-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h5 class="mb-0">Completed</h5>
                    </div>
                    <h2 class="mb-3">{{ $reports->where('report_status', 'Completed')->count() }}</h2>
                    <p class="text-muted mb-0">Successfully resolved</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white p-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Reports</h5>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item filter-item" href="#" data-filter="all">All Reports</a></li>
                        <li><a class="dropdown-item filter-item" href="#" data-filter="Pending">Pending</a></li>
                        <li><a class="dropdown-item filter-item" href="#" data-filter="In Progress">In Progress</a></li>
                        <li><a class="dropdown-item filter-item" href="#" data-filter="Completed">Completed</a></li>
                        <li><a class="dropdown-item filter-item" href="#" data-filter="Rejected">Rejected</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="reportsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Property</th>
                                <th>Room</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="report-row" data-status="{{ $report->report_status }}">
                                    <td class="ps-4">{{ $report->created_at->format('M d, Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($report->room->house->house_address, 30) }}</td>
                                    <td>{{ $report->room->room_type }}</td>
                                    <td>{{ $report->item->item_name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($report->report_desc, 30) }}</td>
                                    <td>
                                        @if($report->report_status == 'Pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                                        @elseif($report->report_status == 'In Progress')
                                            <span class="badge bg-info rounded-pill px-3">In Progress</span>
                                        @elseif($report->report_status == 'Completed')
                                            <span class="badge bg-success rounded-pill px-3">Completed</span>
                                        @elseif($report->report_status == 'Rejected')
                                            <span class="badge bg-danger rounded-pill px-3">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ asset('storage/' . $report->report_image) }}" 
                                           data-lightbox="report-{{ $report->reportID }}" 
                                           data-title="{{ $report->item->item_name }} - {{ $report->report_desc }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-image"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill view-details" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#reportDetailsModal" 
                                                data-report-id="{{ $report->reportID }}"
                                                data-report-date="{{ $report->created_at->format('M d, Y') }}"
                                                data-report-property="{{ $report->room->house->house_address }}"
                                                data-report-room="{{ $report->room->room_type }}"
                                                data-report-item="{{ $report->item->item_name }}"
                                                data-report-desc="{{ $report->report_desc }}"
                                                data-report-status="{{ $report->report_status }}"
                                                data-report-image="{{ asset('storage/' . $report->report_image) }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state mb-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h5>No Reports Found</h5>
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
<div class="modal fade" id="reportDetailsModal" tabindex="-1" aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="reportDetailsModalLabel">Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="report-image-container rounded-4 overflow-hidden">
                            <img src="" alt="Report Image" class="img-fluid report-detail-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="report-status-badge mb-3"></div>
                        <h5 class="report-item-name mb-3"></h5>
                        
                        <div class="report-details">
                            <div class="detail-item mb-3">
                                <span class="detail-label">Property:</span>
                                <span class="detail-value report-property"></span>
                            </div>
                            <div class="detail-item mb-3">
                                <span class="detail-label">Room:</span>
                                <span class="detail-value report-room"></span>
                            </div>
                            <div class="detail-item mb-3">
                                <span class="detail-label">Submitted On:</span>
                                <span class="detail-value report-date"></span>
                            </div>
                            <div class="detail-item mb-3">
                                <span class="detail-label">Description:</span>
                                <p class="detail-value report-desc mt-2"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .rounded-4 {
        border-radius: 0.75rem !important;
    }
    
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1);
    }
    
    .empty-state {
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
    
    .report-image-container {
        height: 300px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .report-detail-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .detail-label {
        font-weight: 600;
        color: #6c757d;
        display: block;
    }
    
    .detail-value {
        font-weight: 400;
        color: #212529;
    }
    
    .report-desc {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false
        });
        
        // Filter functionality
        const filterItems = document.querySelectorAll('.filter-item');
        const reportRows = document.querySelectorAll('.report-row');
        
        filterItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active filter
                filterItems.forEach(fi => fi.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                reportRows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        const status = row.getAttribute('data-status');
                        row.style.display = (status === filter) ? '' : 'none';
                    }
                });
                
                // Update dropdown button text
                document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${filter === 'all' ? 'All Reports' : filter}`;
            });
        });
        
        // View details modal
        const viewDetailsBtns = document.querySelectorAll('.view-details');
        
        viewDetailsBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const reportId = this.getAttribute('data-report-id');
                const reportDate = this.getAttribute('data-report-date');
                const reportProperty = this.getAttribute('data-report-property');
                const reportRoom = this.getAttribute('data-report-room');
                const reportItem = this.getAttribute('data-report-item');
                const reportDesc = this.getAttribute('data-report-desc');
                const reportStatus = this.getAttribute('data-report-status');
                const reportImage = this.getAttribute('data-report-image');
                
                // Update modal content
                document.querySelector('.report-date').textContent = reportDate;
                document.querySelector('.report-property').textContent = reportProperty;
                document.querySelector('.report-room').textContent = reportRoom;
                document.querySelector('.report-item-name').textContent = reportItem;
                document.querySelector('.report-desc').textContent = reportDesc;
                document.querySelector('.report-detail-image').src = reportImage;
                
                // Update status badge
                const statusBadgeContainer = document.querySelector('.report-status-badge');
                let badgeHTML = '';
                
                if (reportStatus === 'Pending') {
                    badgeHTML = '<span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>';
                } else if (reportStatus === 'In Progress') {
                    badgeHTML = '<span class="badge bg-info rounded-pill px-3">In Progress</span>';
                } else if (reportStatus === 'Completed') {
                    badgeHTML = '<span class="badge bg-success rounded-pill px-3">Completed</span>';
                } else if (reportStatus === 'Rejected') {
                    badgeHTML = '<span class="badge bg-danger rounded-pill px-3">Rejected</span>';
                }
                
                statusBadgeContainer.innerHTML = badgeHTML;
            });
        });
    });
</script>
@endpush
@endsection