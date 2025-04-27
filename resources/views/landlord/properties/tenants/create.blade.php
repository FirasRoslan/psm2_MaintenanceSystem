@extends('ui.layout')

@section('title', 'Add Tenant House Assignment')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Add New Tenant House Assignment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.tenants.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tenant Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Tenant Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Tenant Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="approval_status" class="form-label">Tenant Account Status</label>
                            <select class="form-select @error('approval_status') is-invalid @enderror" 
                                    id="approval_status" name="approval_status" required>
                                <option value="active" {{ old('approval_status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="non active" {{ old('approval_status') == 'non active' ? 'selected' : '' }}>Non Active</option>
                            </select>
                            @error('approval_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="house_id" class="form-label">Assign to Property</label>
                            <select class="form-select @error('house_id') is-invalid @enderror" id="house_id" name="house_id" required>
                                <option value="">Select Property</option>
                                @foreach($houses as $house)
                                <option value="{{ $house->houseID }}" {{ old('house_id') == $house->houseID ? 'selected' : '' }}>
                                    {{ $house->house_address }}
                                </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">The tenant's house assignment will be pending approval by default.</small>
                            @error('house_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Tenant House Assignment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection