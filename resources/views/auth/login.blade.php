@extends('ui.layout')

@section('title', 'Login')

@section('content')
<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg position-fixed w-100" style="top: 0; z-index: 1000; background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" style="color: #0d6efd; font-weight: 600; font-size: 1.5rem; text-decoration: none;">
            <i class="fas fa-home me-2" style="color: #0d6efd; font-size: 1.8rem;"></i>
            Parit Raja Rental
        </a>
    </div>
</nav>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center p-0" style="padding-top: 80px !important;">
    <div class="row w-100 h-100 g-0">
        <!-- Left Side - Branding -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center position-relative overflow-hidden">
            <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%); z-index: 1;"></div>
            <div class="position-absolute w-100 h-100" style="background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>'); opacity: 0.3;"></div>
            
            <div class="text-center text-white position-relative" style="z-index: 2;">
                <!-- Main Logo above Welcome Back -->
                <div class="mb-4">
                    <img src="{{ asset('image/logo.png') }}" alt="Parit Raja Rental House" class="img-fluid mb-3" style="width: 120px; height: auto; filter: brightness(0) invert(1);">
                    <!-- Brand Name with Icon -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <i class="fas fa-home me-2" style="font-size: 2rem; opacity: 0.9;"></i>
                        <h3 class="mb-0 fw-bold" style="font-size: 1.8rem;">Parit Raja Rental</h3>
                    </div>
                </div>
                <h1 class="display-4 fw-bold mb-3">Welcome Back</h1>
                <p class="lead mb-4 opacity-90">Manage your properties with ease and efficiency</p>
                <div class="row text-center mt-5">
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-building fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Properties</h6>
                            <small class="opacity-75">Manage all your rental properties</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-users fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Tenants</h6>
                            <small class="opacity-75">Track tenant information</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-chart-line fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Analytics</h6>
                            <small class="opacity-75">Monitor your performance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
            <div class="w-100" style="max-width: 420px; padding: 2rem;">
                <div class="text-center mb-5">
                    <div class="d-lg-none mb-4">
                        <img src="{{ asset('image/logo.png') }}" alt="Parit Raja Rental House" class="img-fluid" style="width: 80px; height: auto;">
                    </div>
                    <h2 class="fw-bold text-dark mb-2">Sign In</h2>
                    <p class="text-muted">Enter your credentials to access your account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <div class="small">{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-dark fw-semibold">
                            <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                        </label>
                        <input type="email" 
                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="Enter your email address"
                               style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-dark fw-semibold">
                            <i class="fas fa-lock me-2 text-muted"></i>Password
                        </label>
                        <div class="position-relative">
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Enter your password"
                                   style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem; padding-right: 3rem;">
                            <button type="button" 
                                    class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0" 
                                    style="background: none; border: none; color: #6b7280; width: 2rem; height: 2rem;"
                                    onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">
                                Remember me for 30 days
                            </label>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.875rem; font-size: 1.1rem;">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #667eea; font-weight: 500;">
                            <i class="fas fa-key me-1"></i>Forgot your password?
                        </a>
                    </div>
                </form>

                <div class="text-center mt-4 pt-4 border-top">
                    <p class="text-muted mb-0">Don't have an account? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #667eea;">Create account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Enhanced input focus effects
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
            this.style.boxShadow = '0 0 0 0.2rem rgba(102, 126, 234, 0.25)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e5e7eb';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

<style>
.navbar-brand:hover {
    color: #0a58ca !important;
    transform: translateY(-1px);
    transition: all 0.3s ease;
}

.navbar-brand i {
    transition: all 0.3s ease;
}

.navbar-brand:hover i {
    transform: scale(1.1);
}

@media (max-width: 991px) {
    .container-fluid {
        padding-top: 100px !important;
    }
}
</style>
@endsection