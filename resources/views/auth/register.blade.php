@extends('ui.layout')

@section('title', 'Register')

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
            <div class="position-absolute w-100 h-100" style="background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>'); opacity: 0.3;"></div>
            
            <div class="text-center text-white position-relative" style="z-index: 2;">
                <div class="mb-4">
                    <img src="{{ asset('image/logo.png') }}" alt="Parit Raja Rental House" class="img-fluid mb-3" style="width: 120px; height: auto; filter: brightness(0) invert(1);">
                    <!-- Brand Name with Icon -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <i class="fas fa-home me-2" style="font-size: 2rem; opacity: 0.9;"></i>
                        <h3 class="mb-0 fw-bold" style="font-size: 1.8rem;">Parit Raja Rental</h3>
                    </div>
                </div>
                <h1 class="display-4 fw-bold mb-3">Join Our Community</h1>
                <p class="lead mb-4 opacity-90">Start managing your rental properties today</p>
                <div class="row text-center mt-5">
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-user-plus fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Easy Setup</h6>
                            <small class="opacity-75">Quick registration process</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-shield-alt fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Secure</h6>
                            <small class="opacity-75">Your data is protected</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3">
                            <i class="fas fa-rocket fa-2x mb-2 opacity-75"></i>
                            <h6 class="fw-semibold">Get Started</h6>
                            <small class="opacity-75">Begin your journey</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
            <div class="w-100" style="max-width: 420px; padding: 2rem;">
                <div class="text-center mb-4">
                    <div class="d-lg-none mb-4">
                        <img src="{{ asset('image/logo.png') }}" alt="Parit Raja Rental House" class="img-fluid" style="width: 80px; height: auto;">
                    </div>
                    <h2 class="fw-bold text-dark mb-2">Create Account</h2>
                    <p class="text-muted">Fill in your information to get started</p>
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

                <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-semibold">
                            <i class="fas fa-user me-2 text-muted"></i>Full Name
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus
                               placeholder="Enter your full name"
                               style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem;">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-dark fw-semibold">
                            <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                        </label>
                        <input type="email" 
                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               placeholder="Enter your email address"
                               style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-dark fw-semibold">
                            <i class="fas fa-lock me-2 text-muted"></i>Password
                        </label>
                        <div class="position-relative">
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Create a strong password"
                                   style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem; padding-right: 3rem;">
                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0" style="background: none; border: none; color: #6b7280;" onclick="togglePassword('password', 'togglePasswordIcon1')">
                                <i class="fas fa-eye" id="togglePasswordIcon1"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted mt-1">
                            <small><i class="fas fa-info-circle me-1"></i>Password must be at least 8 characters long</small>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label text-dark fw-semibold">
                            <i class="fas fa-lock me-2 text-muted"></i>Confirm Password
                        </label>
                        <div class="position-relative">
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   placeholder="Confirm your password"
                                   style="border: 2px solid #e5e7eb; padding: 0.875rem 1rem; font-size: 1rem; padding-right: 3rem;">
                            <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0" style="background: none; border: none; color: #6b7280;" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')">
                                <i class="fas fa-eye" id="togglePasswordIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-dark fw-semibold mb-3">
                            <i class="fas fa-user-tag me-2 text-muted"></i>I am registering as:
                        </label>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="role-option" data-role="landlord">
                                    <input class="form-check-input" type="radio" name="role" id="role_landlord" value="landlord" {{ old('role') == 'landlord' ? 'checked' : '' }} required>
                                    <label class="role-label" for="role_landlord">
                                        <div class="role-icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="role-content">
                                            <div class="role-title">Landlord</div>
                                            <div class="role-description">Manage properties and tenants</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="role-option" data-role="tenant">
                                    <input class="form-check-input" type="radio" name="role" id="role_tenant" value="tenant" {{ old('role') == 'tenant' ? 'checked' : '' }}>
                                    <label class="role-label" for="role_tenant">
                                        <div class="role-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="role-content">
                                            <div class="role-title">Tenant</div>
                                            <div class="role-description">Find and rent properties</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="role-option" data-role="contractor">
                                    <input class="form-check-input" type="radio" name="role" id="role_contractor" value="contractor" {{ old('role') == 'contractor' ? 'checked' : '' }}>
                                    <label class="role-label" for="role_contractor">
                                        <div class="role-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <div class="role-content">
                                            <div class="role-title">Contractor</div>
                                            <div class="role-description">Provide maintenance services</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; padding: 0.875rem; border-radius: 12px; transition: all 0.3s ease;">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <span class="text-muted">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold ms-1" style="color: #6366f1;">
                            Sign in here
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

.form-control:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25) !important;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

.alert {
    animation: slideInDown 0.3s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Role Selection Styles */
.role-option {
    position: relative;
    margin-bottom: 0.75rem;
}

.role-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.role-label {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    margin: 0;
}

.role-label:hover {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}

.role-option input[type="radio"]:checked + .role-label {
    border-color: #6366f1;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
}

.role-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    transition: all 0.3s ease;
}

.role-icon i {
    color: white;
    font-size: 1.25rem;
}

.role-content {
    flex: 1;
}

.role-title {
    font-weight: 600;
    color: #374151;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.role-description {
    color: #6b7280;
    font-size: 0.9rem;
}

.role-option input[type="radio"]:checked + .role-label .role-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.role-option input[type="radio"]:checked + .role-label .role-title {
    color: #6366f1;
}

/* Mobile responsiveness */
@media (max-width: 991.98px) {
    .container-fluid {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .col-lg-6:last-child {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        border-radius: 20px 20px 0 0;
        margin-top: 5vh;
    }
    
    .role-label {
        padding: 0.875rem;
    }
    
    .role-icon {
        width: 45px;
        height: 45px;
        margin-right: 0.875rem;
    }
    
    .role-icon i {
        font-size: 1.1rem;
    }
}

/* Form validation styles */
.was-validated .form-control:valid {
    border-color: #10b981;
}

.was-validated .form-control:invalid {
    border-color: #ef4444;
}

/* Password strength indicator */
.password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 0.5rem;
    transition: all 0.3s ease;
}

.password-strength.weak {
    background: linear-gradient(90deg, #ef4444 0%, #ef4444 33%, #e5e7eb 33%, #e5e7eb 100%);
}

.password-strength.medium {
    background: linear-gradient(90deg, #f59e0b 0%, #f59e0b 66%, #e5e7eb 66%, #e5e7eb 100%);
}

.password-strength.strong {
    background: linear-gradient(90deg, #10b981 0%, #10b981 100%);
}
</style>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    
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

// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    const inputs = form.querySelectorAll('input');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    // Input focus effects
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.borderColor = '#6366f1';
            this.style.boxShadow = '0 0 0 0.2rem rgba(99, 102, 241, 0.25)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
            this.style.borderColor = '#e5e7eb';
            this.style.boxShadow = 'none';
        });
    });
    
    // Password strength indicator
    if (passwordInput) {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.className = 'password-strength';
        passwordInput.parentNode.appendChild(strengthIndicator);
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            strengthIndicator.className = 'password-strength';
            if (strength <= 1) {
                strengthIndicator.classList.add('weak');
            } else if (strength <= 2) {
                strengthIndicator.classList.add('medium');
            } else {
                strengthIndicator.classList.add('strong');
            }
        });
    }
    
    // Password confirmation validation
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Role selection enhancement
    const roleOptions = document.querySelectorAll('.role-option');
    roleOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Remove active class from all options
            roleOptions.forEach(opt => opt.classList.remove('active'));
            // Add active class to clicked option
            this.classList.add('active');
        });
    });
    
    // Form submission validation
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endsection