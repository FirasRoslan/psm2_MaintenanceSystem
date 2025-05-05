@extends('ui.layout')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create an Account</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">I am registering as a:</label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="role_landlord" value="landlord" {{ old('role') == 'landlord' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="role_landlord">
                                        <i class="fas fa-home me-1"></i> Landlord
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="role_tenant" value="tenant" {{ old('role') == 'tenant' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_tenant">
                                        <i class="fas fa-user me-1"></i> Tenant
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="role_contractor" value="contractor" {{ old('role') == 'contractor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_contractor">
                                        <i class="fas fa-tools me-1"></i> Contractor
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>

                    <div class="mt-3 text-center">
                        <div>
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection