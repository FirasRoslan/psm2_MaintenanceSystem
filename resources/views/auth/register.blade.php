@extends('ui.layout')

@section('title', 'Register')

@section('content')
<style>
:root {
    --primary-blue: #3b82f6;
    --light-blue: #dbeafe;
    --dark-blue: #1e40af;
    --accent-gold: #f59e0b;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --white: #ffffff;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
    min-height: 100vh;
}

.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.auth-card {
    background: var(--white);
    border-radius: 24px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    width: 100%;
    max-width: 1200px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 700px;
}

.auth-brand {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: var(--white);
    position: relative;
    overflow: hidden;
}

.auth-brand::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
}

.brand-content {
    position: relative;
    z-index: 2;
}

.brand-logo {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    backdrop-filter: blur(10px);
}

.brand-logo i {
    font-size: 2.5rem;
    color: var(--white);
}

.brand-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.brand-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    line-height: 1.5;
}

.feature-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    width: 100%;
}

.feature-item {
    text-align: left;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.feature-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
}

.feature-icon i {
    font-size: 1.2rem;
    color: var(--white);
}

.feature-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.feature-desc {
    font-size: 0.875rem;
    opacity: 0.8;
    line-height: 1.4;
}

.auth-form {
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-height: 700px;
    overflow-y: auto;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-subtitle {
    color: var(--text-light);
    font-size: 1rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-100);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: var(--white);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
    color: var(--text-light);
}

.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    padding: 0.25rem;
}

.role-selection {
    margin-bottom: 1.5rem;
}

.role-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
    margin-top: 0.75rem;
}

.role-card {
    border: 2px solid var(--gray-100);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: var(--white);
}

.role-card:hover {
    border-color: var(--primary-blue);
    background: var(--light-blue);
}

.role-card.selected {
    border-color: var(--primary-blue);
    background: var(--light-blue);
}

.role-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-blue);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    color: var(--white);
}

.role-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.role-desc {
    font-size: 0.75rem;
    color: var(--text-light);
    line-height: 1.3;
}

.btn-primary {
    width: 100%;
    padding: 0.875rem;
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
    color: var(--white);
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 1.5rem;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
}

.form-footer {
    text-align: center;
    color: var(--text-light);
    font-size: 0.875rem;
}

.form-footer a {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 600;
}

.form-footer a:hover {
    text-decoration: underline;
}

.alert {
    padding: 0.875rem 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.alert-danger {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

@media (max-width: 768px) {
    .auth-card {
        grid-template-columns: 1fr;
        max-width: 400px;
    }
    
    .auth-brand {
        padding: 2rem;
        min-height: auto;
    }
    
    .auth-form {
        padding: 2rem;
        max-height: none;
    }
    
    .feature-grid {
        display: none;
    }
    
    .role-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
}
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Brand Side -->
        <div class="auth-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-home"></i>
                </div>
                <h1 class="brand-title">Join Our Community</h1>
                <p class="brand-subtitle">Start managing your rental properties today and connect with thousands of tenants.</p>
                
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="feature-title">Easy Setup</div>
                        <div class="feature-desc">Quick registration process to get you started</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-title">Secure</div>
                        <div class="feature-desc">Your data is protected with enterprise-grade security</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-title">24/7 Support</div>
                        <div class="feature-desc">Get help whenever you need it from our support team</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form">
            <div class="form-header">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Fill in your information to get started</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i> Full Name
                    </label>
                    <input type="text" id="name" name="name" class="form-input" 
                           placeholder="Enter your full name" 
                           value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i> Email Address
                    </label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email address" 
                           value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-1"></i> Phone Number
                    </label>
                    <input type="tel" id="phone" name="phone" class="form-input" 
                           placeholder="Enter your phone number" 
                           value="{{ old('phone') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> Password
                    </label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" class="form-input" 
                               placeholder="Create a strong password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'password-icon')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-1"></i> Confirm Password
                    </label>
                    <div class="password-field">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                               placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'confirm-password-icon')">
                            <i class="fas fa-eye" id="confirm-password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="role-selection">
                    <label class="form-label">
                        <i class="fas fa-user-tag me-1"></i> I am registering as
                    </label>
                    <div class="role-grid">
                        <div class="role-card" onclick="selectRole('landlord')">
                            <div class="role-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="role-title">Landlord</div>
                            <div class="role-desc">Manage properties and tenants</div>
                            <input type="radio" name="role" value="landlord" id="role-landlord" style="display: none;">
                        </div>
                        <div class="role-card" onclick="selectRole('tenant')">
                            <div class="role-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="role-title">Tenant</div>
                            <div class="role-desc">Find and rent properties</div>
                            <input type="radio" name="role" value="tenant" id="role-tenant" style="display: none;">
                        </div>
                        <div class="role-card" onclick="selectRole('contractor')">
                            <div class="role-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="role-title">Contractor</div>
                            <div class="role-desc">Provide maintenance services</div>
                            <input type="radio" name="role" value="contractor" id="role-contractor" style="display: none;">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
            </form>
            
            <div class="form-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const passwordIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}

function selectRole(role) {
    // Remove selected class from all cards
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Check the corresponding radio button
    document.getElementById('role-' + role).checked = true;
}
</script>
@endsection