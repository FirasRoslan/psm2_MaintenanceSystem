@extends('ui.layout')
@section('title', 'Profile')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        User Profile
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="profile-avatar">
                                <div class="avatar-circle">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                                <h5 class="mt-3">{{ $user->name }}</h5>
                                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="profile-info">
                                <div class="info-item mb-3">
                                    <label class="form-label fw-bold">Name:</label>
                                    <p class="form-control-plaintext">{{ $user->name }}</p>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-bold">Email:</label>
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-bold">Phone:</label>
                                    <p class="form-control-plaintext">{{ $user->phone ?? 'Not provided' }}</p>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-bold">Role:</label>
                                    <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-bold">Member Since:</label>
                                    <p class="form-control-plaintext">{{ $user->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto;
}

.profile-info .info-item {
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 0.5rem;
}

.profile-info .info-item:last-child {
    border-bottom: none;
}
</style>
@endsection