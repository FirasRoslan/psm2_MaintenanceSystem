@extends('ui.layout')

@section('title', 'Manage Tenant House Assignments')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Tenant House Assignments</h4>
            <p class="text-muted mb-0">Manage your property tenant assignments</p>
        </div>
        <a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Assignment
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
        <div class="card-body p-0">
            @if($tenants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Tenant</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0">Property</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Assignment</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $tenant)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        <span class="initials">{{ substr($tenant->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $tenant->name }}</h6>
                                        <small class="text-muted">Tenant</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <p class="mb-0"><i class="fas fa-envelope text-muted me-2"></i>{{ $tenant->email }}</p>
                                    <p class="mb-0"><i class="fas fa-phone text-muted me-2"></i>{{ $tenant->phone }}</p>
                                </div>
                            </td>
                            <td>
                                @if($tenant->tenantHouses->count() > 0)
                                    @php
                                        $house = $tenant->tenantHouses->first();
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="property-img me-2">
                                            <img src="{{ asset('storage/' . $house->house_image) }}" alt="Property" class="img-fluid rounded">
                                        </div>
                                        <span>{{ $house->house_address }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $tenant->approval_status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                                    {{ ucfirst($tenant->approval_status) }}
                                </span>
                            </td>
                            <!-- Update the assignment status display in the index table -->
                            <td>
                                @if($tenant->tenantHouses->count() > 0)
                                    @php
                                        $pivotData = $tenant->tenantHouses->first()->pivot;
                                    @endphp
                                    @if($pivotData->approval_status === null)
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Pending</span>
                                    @elseif($pivotData->approval_status == 1)
                                        <span class="badge rounded-pill bg-success px-3 py-2">Approved</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger px-3 py-2">Rejected</span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('landlord.tenants.show', $tenant->userID) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Assignment">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('landlord.tenants.delete', $tenant->userID) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="tooltip" title="Delete Assignment">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <img src="{{ asset('images/empty.svg') }}" alt="No tenant assignments" class="img-fluid mb-4" style="max-height: 200px;">
                <h5>No Tenant House Assignments Found</h5>
                <p class="text-muted">You haven't added any tenant house assignments yet.</p>
                <a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i>Add Tenant Assignment
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background-color: #0ea5e9;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.initials {
    font-size: 16px;
    color: white;
    font-weight: bold;
}

.property-img {
    width: 40px;
    height: 40px;
    overflow: hidden;
}

.property-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.badge {
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem 1.25rem;
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
    // Handle delete confirmation
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this tenant house assignment?')) {
                this.closest('.delete-form').submit();
            }
        });
    });
</script>
@endpush
@endsection