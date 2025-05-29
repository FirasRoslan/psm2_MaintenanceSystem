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
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
        font-size: 1.1rem;
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
    
    /* Filter Tabs Container */
    .filter-tabs-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .filter-tabs-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem;
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
        font-size: 1.3rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .filter-subtitle {
        color: #64748b;
        font-size: 0.9rem;
    }
    
    .filter-tabs-body {
        padding: 1.5rem;
    }
    
    /* Enhanced Nav Pills */
    .nav-pills .nav-link {
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 15px;
        padding: 1rem;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
        color: #64748b;
        font-weight: 500;
    }
    
    .nav-pills .nav-link:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .tab-content-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .tab-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .tab-label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .tab-badge {
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 30px;
    }
    
    .nav-pills .nav-link:not(.active) .tab-badge {
        background: #cbd5e1;
        color: #475569;
    }
    
    .nav-pills .nav-link:not(.active) .tab-badge.pending {
        background: #fbbf24;
        color: #92400e;
    }
    
    .nav-pills .nav-link:not(.active) .tab-badge.progress {
        background: #60a5fa;
        color: #1e40af;
    }
    
    .nav-pills .nav-link:not(.active) .tab-badge.completed {
        background: #34d399;
        color: #065f46;
    }
    
    /* Button Styling */
    .btn {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-outline-primary {
        color: #667eea;
        border-color: #667eea;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    
    .btn-outline-primary:hover {
        background: #667eea;
        border-color: #667eea;
        transform: translateY(-2px);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .nav-pills .nav-link {
            margin: 0.25rem;
            padding: 0.75rem;
        }
        
        .tab-icon {
            font-size: 1.2rem;
        }
        
        .tab-label {
            font-size: 0.8rem;
        }
    }
</style>
@endpush
@endsection