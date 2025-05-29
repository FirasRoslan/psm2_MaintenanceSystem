@extends('ui.layout')

@section('title', 'Maintenance History')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-5">
        <div class="header-content">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="breadcrumb-nav mb-2">
                        <span class="breadcrumb-item">Dashboard</span>
                        <i class="fas fa-chevron-right mx-2 text-muted"></i>
                        <span class="breadcrumb-item active">Maintenance History</span>
                    </div>
                    <h2 class="page-title mb-2">Maintenance History</h2>
                    <p class="page-description">View all completed maintenance reports and track your property maintenance timeline</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="main-card">
        <div class="card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <div class="header-info">
                    <h5 class="mb-1">Completed Reports</h5>
                    <p class="text-muted mb-0">{{ $completedReports->total() }} total maintenance reports completed</p>
                </div>
                <div class="header-stats">
                    <div class="stat-badge">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span class="fw-medium">{{ $completedReports->count() }}</span>
                        <small class="text-muted ms-1">this page</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($completedReports->count() > 0)
                <div class="history-grid">
                    @foreach($completedReports as $report)
                        <div class="history-card">
                            <div class="history-card-header">
                                <div class="property-info">
                                    <div class="property-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="property-details">
                                        <h6 class="property-address mb-1">{{ $report->room->house->house_address }}</h6>
                                        <span class="room-type">{{ $report->room->room_type }}</span>
                                    </div>
                                </div>
                                <div class="completion-badge">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span class="badge bg-success-soft text-success">Completed</span>
                                </div>
                            </div>

                            <div class="history-card-body">
                                <div class="maintenance-item">
                                    <div class="item-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div class="item-details">
                                        <h6 class="item-name">{{ $report->item->item_name }}</h6>
                                        <p class="reported-by">Reported by <strong>{{ $report->user->name }}</strong></p>
                                    </div>
                                </div>

                                <div class="timeline-info">
                                    <div class="timeline-item">
                                        <div class="timeline-icon reported">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <span class="timeline-label">Reported</span>
                                            <span class="timeline-date">{{ $report->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="timeline-connector"></div>
                                    <div class="timeline-item">
                                        <div class="timeline-icon completed">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <span class="timeline-label">Completed</span>
                                            <span class="timeline-date">
                                                @if($report->tasks->isNotEmpty() && $report->tasks->first()->completed_at)
                                                    {{ \Carbon\Carbon::parse($report->tasks->first()->completed_at)->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($report->tasks->isNotEmpty())
                                    <div class="contractor-info">
                                        <div class="contractor-avatar">
                                            <i class="fas fa-user-hard-hat"></i>
                                        </div>
                                        <div class="contractor-details">
                                            <span class="contractor-label">Handled by</span>
                                            <span class="contractor-name">{{ $report->tasks->first()->contractor->name }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="history-card-footer">
                                <a href="{{ route('landlord.requests.show', $report->reportID) }}" class="btn btn-primary-gradient btn-sm">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                                <div class="duration-info">
                                    @if($report->tasks->isNotEmpty() && $report->tasks->first()->completed_at)
                                        @php
                                            $duration = $report->created_at->diffInDays(\Carbon\Carbon::parse($report->tasks->first()->completed_at));
                                        @endphp
                                        <span class="duration-badge">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $duration }} {{ $duration == 1 ? 'day' : 'days' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $completedReports->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-illustration">
                        <div class="empty-state-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="empty-state-rings">
                            <div class="ring ring-1"></div>
                            <div class="ring ring-2"></div>
                            <div class="ring ring-3"></div>
                        </div>
                    </div>
                    <div class="empty-state-content">
                        <h4 class="empty-state-title">No Maintenance History Yet</h4>
                        <p class="empty-state-description">Once maintenance reports are completed, they will appear here for your review and records.</p>
                        <a href="{{ route('landlord.requests.index') }}" class="btn btn-primary-gradient mt-3">
                            <i class="fas fa-plus me-2"></i>View Active Requests
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-nav {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .breadcrumb-item.active {
        font-weight: 600;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions .btn {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .header-actions .btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Main Card Styling */
    .main-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .header-info h5 {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .stat-badge {
        background: white;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        font-size: 0.875rem;
    }

    /* History Grid */
    .history-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
    }

    .history-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .history-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .history-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.25rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .property-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .property-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .property-address {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.3;
    }

    .room-type {
        font-size: 0.875rem;
        opacity: 0.9;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .completion-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .bg-success-soft {
        background-color: rgba(40, 167, 69, 0.1) !important;
        color: #28a745 !important;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .history-card-body {
        padding: 1.5rem;
    }

    .maintenance-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f3f4;
    }

    .item-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }

    .item-name {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.25rem 0;
    }

    .reported-by {
        font-size: 0.875rem;
        color: #6c757d;
        margin: 0;
    }

    /* Timeline Styling */
    .timeline-info {
        margin-bottom: 1.5rem;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        color: white;
    }

    .timeline-icon.reported {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    }

    .timeline-icon.completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .timeline-content {
        display: flex;
        flex-direction: column;
    }

    .timeline-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d3748;
    }

    .timeline-date {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .timeline-connector {
        width: 2px;
        height: 20px;
        background: linear-gradient(to bottom, #e9ecef 0%, #dee2e6 100%);
        margin: -0.5rem 0 -0.5rem 15px;
    }

    /* Contractor Info */
    .contractor-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .contractor-avatar {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .contractor-details {
        display: flex;
        flex-direction: column;
    }

    .contractor-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .contractor-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d3748;
    }

    /* Card Footer */
    .history-card-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e9ecef;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-weight: 500;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .duration-badge {
        background: white;
        color: #6c757d;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid #e9ecef;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        position: relative;
    }

    .empty-state-illustration {
        position: relative;
        margin-bottom: 2rem;
        display: inline-block;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .empty-state-rings {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .ring {
        position: absolute;
        border: 2px solid rgba(102, 126, 234, 0.2);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .ring-1 {
        width: 140px;
        height: 140px;
        top: -70px;
        left: -70px;
    }

    .ring-2 {
        width: 180px;
        height: 180px;
        top: -90px;
        left: -90px;
        animation-delay: 0.5s;
    }

    .ring-3 {
        width: 220px;
        height: 220px;
        top: -110px;
        left: -110px;
        animation-delay: 1s;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.1);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
    }

    .empty-state-description {
        font-size: 1rem;
        color: #6c757d;
        max-width: 400px;
        margin: 0 auto 1.5rem;
        line-height: 1.6;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 2rem;
        display: flex;
        justify-content: center;
        border-top: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .history-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
            gap: 1rem;
        }

        .header-actions {
            margin-top: 1rem;
        }

        .card-header-modern {
            padding: 1rem;
        }

        .history-card-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .completion-badge {
            align-self: flex-end;
        }
    }

    @media (max-width: 480px) {
        .history-card-footer {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }

        .duration-info {
            text-align: center;
        }
    }
</style>
@endpush
@endsection