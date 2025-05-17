@extends('ui.layout')

@section('title', 'Edit Tenant House Assignment')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Edit Tenant House Assignment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.tenants.update', $tenant->userID) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tenant Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $tenant->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Tenant Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $tenant->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Tenant Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="approval_status" class="form-label">Tenant Account Status</label>
                            <select class="form-select @error('approval_status') is-invalid @enderror" 
                                    id="approval_status" name="approval_status" required>
                                <option value="active" {{ (old('approval_status', $tenant->approval_status) == 'active') ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="non active" {{ (old('approval_status', $tenant->approval_status) == 'non active') ? 'selected' : '' }}>
                                    Non Active
                                </option>
                            </select>
                            @error('approval_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="house_id" class="form-label">Assign to Property</label>
                            <select class="form-select @error('house_id') is-invalid @enderror" id="house_id" name="house_id" required>
                                <option value="">Select Property</option>
                                @foreach($houses as $house)
                                <option value="{{ $house->houseID }}" 
                                    {{ (old('house_id') == $house->houseID || in_array($house->houseID, $assignedHouses)) ? 'selected' : '' }}>
                                    {{ $house->house_address }}
                                </option>
                                @endforeach
                            </select>
                            @error('house_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Update the assignment status dropdown in the edit form -->
                        <div class="mb-4">
                            <label for="assignment_status" class="form-label">Assignment Status</label>
                            <select class="form-select @error('assignment_status') is-invalid @enderror" 
                                    id="assignment_status" name="assignment_status" required>
                                @php
                                    $currentStatus = 'pending';
                                    if ($tenant->tenantHouses->count() > 0) {
                                        $pivotStatus = $tenant->tenantHouses->first()->pivot->approval_status;
                                        if ($pivotStatus === true) {
                                            $currentStatus = 'approve';
                                        } elseif ($pivotStatus === false) {
                                            $currentStatus = 'reject';
                                        }
                                    }
                                @endphp
                                <option value="pending" {{ old('assignment_status', $currentStatus) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="approve" {{ old('assignment_status', $currentStatus) == 'approve' ? 'selected' : '' }}>
                                    Approve
                                </option>
                                <option value="reject" {{ old('assignment_status', $currentStatus) == 'reject' ? 'selected' : '' }}>
                                    Reject
                                </option>
                            </select>
                            @error('assignment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="house_approval_status" class="form-label">House Assignment Status</label>
                            <select class="form-select @error('house_approval_status') is-invalid @enderror" 
                                    id="house_approval_status" name="house_approval_status" required>
                                <option value="pending" 
                                    {{ old('house_approval_status', ($tenant->tenantHouses->first() && $tenant->tenantHouses->first()->pivot->approval_status === null) ? 'pending' : '') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="approve" 
                                    {{ old('house_approval_status', ($tenant->tenantHouses->first() && $tenant->tenantHouses->first()->pivot->approval_status === true) ? 'approve' : '') == 'approve' ? 'selected' : '' }}>
                                    Approve
                                </option>
                                <option value="reject" 
                                    {{ old('house_approval_status', ($tenant->tenantHouses->first() && $tenant->tenantHouses->first()->pivot->approval_status === false) ? 'reject' : '') == 'reject' ? 'selected' : '' }}>
                                    Reject
                                </option>
                            </select>
                            @error('house_approval_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Tenant House Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection