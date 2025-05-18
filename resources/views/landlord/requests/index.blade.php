@extends('ui.layout')

@section('title', 'Maintenance Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Maintenance Requests</h4>
            <p class="text-muted mb-0">View and manage maintenance requests from tenants</p>
        </div>
        <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-primary">
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
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Tenant</th>
                                <th>Property</th>
                                <th>Room</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $report->created_at->format('M d, Y') }}</td>
                                    <td>{{ $report->user->name }}</td>
                                    <td>{{ $report->room->house->house_address }}</td>
                                    <td>{{ $report->room->room_type }}</td>
                                    <td>{{ $report->item->item_name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($report->report_desc, 50) }}</td>
                                    <td>
                                        @if($report->report_status == 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($report->report_status == 'In Progress')
                                            <span class="badge bg-info">In Progress</span>
                                        @elseif($report->report_status == 'Completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($report->report_status == 'Rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $report->report_image) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-image"></i> View
                                        </a>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $report->reportID }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $report->reportID }}">
                                                <li>
                                                    <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="In Progress">
                                                        <button type="submit" class="dropdown-item">Mark as In Progress</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Completed">
                                                        <button type="submit" class="dropdown-item">Mark as Completed</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('landlord.requests.update-status', $report->reportID) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Rejected">
                                                        <button type="submit" class="dropdown-item">Reject Request</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route('landlord.requests.assign-task', $report->reportID) }}" class="dropdown-item">
                                                        Assign to Contractor
                                                    </a>
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
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5>No Maintenance Requests</h5>
                    <p class="text-muted">There are no maintenance requests from tenants at this time.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection