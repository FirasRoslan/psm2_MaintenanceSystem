@extends('ui.layout')

@section('title', 'Manage Tenants')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manage Tenants</h4>
        <a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Tenant
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($tenants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Property</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->name }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->phone }}</td>
                            <td>
                                @if($tenant->tenantHouses->count() > 0)
                                    {{ $tenant->tenantHouses->first()->house_address }}
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('landlord.tenants.show', $tenant->userID) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('landlord.tenants.edit', $tenant->userID) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('landlord.tenants.delete', $tenant->userID) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this tenant?')">
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
            <div class="text-center py-4">
                <img src="{{ asset('images/empty.svg') }}" alt="No tenants" class="img-fluid mb-3" style="max-height: 200px;">
                <h5>No Tenants Found</h5>
                <p class="text-muted">You haven't added any tenants yet.</p>
                <a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-2"></i>Add Tenant
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection