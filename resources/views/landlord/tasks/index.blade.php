@extends('ui.layout')

@section('title', 'Task Progress Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('landlord.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Task Management</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center">
                    <div class="page-icon me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h1 class="page-title mb-1">Task Progress Management</h1>
                        <p class="page-description mb-0">Monitor maintenance progress by contractors with detailed phase tracking</p>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
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

    <!-- Enhanced Status Filter Tabs -->
    <div class="filter-tabs-container mb-4">
        <div class="filter-tabs-header">
            <div class="d-flex align-items-center">
                <div class="filter-icon me-3">
                    <i class="fas fa-filter"></i>
                </div>
                <div>
                    <h5 class="filter-title mb-0">Filter Tasks</h5>
                    <p class="filter-subtitle mb-0">View tasks by status</p>
                </div>
            </div>
        </div>
        <div class="filter-tabs-body">
            <ul class="nav nav-pills nav-fill border-0" id="statusTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                        <div class="tab-content-wrapper">
                            <i class="fas fa-list tab-icon"></i>
                            <span class="tab-label">All Tasks</span>
                            <span class="tab-badge">{{ $tasks->count() }}</span>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" type="button" role="tab">
                        <div class="tab-content-wrapper">
                            <i class="fas fa-clock tab-icon"></i>
                            <span class="tab-label">Pending</span>
                            <span class="tab-badge pending">{{ $tasksByStatus->get('pending', collect())->count() }}</span>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="progress-tab" data-bs-toggle="pill" data-bs-target="#progress" type="button" role="tab">
                        <div class="tab-content-wrapper">
                            <i class="fas fa-tools tab-icon"></i>
                            <span class="tab-label">In Progress</span>
                            <span class="tab-badge progress">{{ $tasksByStatus->get('in_progress', collect())->count() }}</span>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="awaiting-tab" data-bs-toggle="pill" data-bs-target="#awaiting" type="button" role="tab">
                        <div class="tab-content-wrapper">
                            <i class="fas fa-hourglass-half tab-icon"></i>
                            <span class="tab-label">Awaiting Approval</span>
                            <span class="tab-badge awaiting">{{ $tasksByStatus->get('awaiting_approval', collect())->count() }}</span>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab">
                        <div class="tab-content-wrapper">
                            <i class="fas fa-check tab-icon"></i>
                            <span class="tab-label">Completed</span>
                            <span class="tab-badge completed">{{ $tasksByStatus->get('completed', collect())->count() }}</span>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tasks Content -->
    <div class="tab-content" id="statusTabsContent">
        <!-- All Tasks -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            @include('landlord.tasks.partials.task-list', ['tasks' => $tasks])
        </div>
        
        <!-- Pending Tasks -->
        <div class="tab-pane fade" id="pending" role="tabpanel">
            @include('landlord.tasks.partials.task-list', ['tasks' => $tasksByStatus->get('pending', collect())])
        </div>
        
        <!-- In Progress Tasks -->
        <div class="tab-pane fade" id="progress" role="tabpanel">
            @include('landlord.tasks.partials.task-list', ['tasks' => $tasksByStatus->get('in_progress', collect())])
        </div>
        
        <!-- Completed Tasks -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            @include('landlord.tasks.partials.task-list', ['tasks' => $tasksByStatus->get('completed', collect())])
        </div>
        
        <!-- Add awaiting approval tab content -->
        <div class="tab-pane fade" id="awaiting" role="tabpanel">
            @include('landlord.tasks.partials.task-list', ['tasks' => $tasksByStatus->get('awaiting_approval', collect())])
        </div>
    </div>
</div>

<style>
/* Enhanced Page Header Styles */
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
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
}

.page-header * {
    position: relative;
    z-index: 1;
}

.page-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
}

.page-description {
    opacity: 0.9;
    font-size: 1rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

/* Enhanced Filter Tabs */
.filter-tabs-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.filter-tabs-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.filter-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.filter-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
}

.filter-subtitle {
    color: #64748b;
    font-size: 0.9rem;
}

.filter-tabs-body {
    padding: 0;
}

.nav-pills {
    background: none;
    padding: 0;
}

.nav-pills .nav-item {
    flex: 1;
}

.nav-pills .nav-link {
    background: none;
    border: none;
    border-radius: 0;
    padding: 1.5rem 1rem;
    color: #64748b;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    border-right: 1px solid #e2e8f0;
}

.nav-pills .nav-item:last-child .nav-link {
    border-right: none;
}

.nav-pills .nav-link:hover {
    background: #f8fafc;
    color: #3b82f6;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.nav-pills .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid #f8fafc;
}

.tab-content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.tab-icon {
    font-size: 1.2rem;
}

.tab-label {
    font-size: 0.9rem;
    font-weight: 600;
}

.tab-badge {
    background: rgba(255, 255, 255, 0.2);
    color: inherit;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    min-width: 24px;
    text-align: center;
}

.nav-pills .nav-link:not(.active) .tab-badge {
    background: #e2e8f0;
    color: #64748b;
}

.nav-pills .nav-link:not(.active) .tab-badge.pending {
    background: #fef3c7;
    color: #d97706;
}

.nav-pills .nav-link:not(.active) .tab-badge.progress {
    background: #dbeafe;
    color: #2563eb;
}

.nav-pills .nav-link:not(.active) .tab-badge.completed {
    background: #d1fae5;
    color: #059669;
}

.tab-badge.awaiting {
    background-color: #fbbf24;
    color: #92400e;
}

/* Enhanced Alert Styles */
.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid #86efac;
    color: #065f46;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .filter-tabs-header {
        padding: 1rem;
    }
    
    .nav-pills .nav-link {
        padding: 1rem 0.5rem;
    }
    
    .tab-content-wrapper {
        gap: 0.25rem;
    }
    
    .tab-label {
        font-size: 0.8rem;
    }
}
</style>
@endsection