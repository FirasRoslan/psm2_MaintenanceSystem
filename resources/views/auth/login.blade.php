@extends('ui.layout')

@section('title', 'Login')

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
    max-width: 1000px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 600px;
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
    margin-bottom: 1.5rem;
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

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    font-size: 0.875rem;
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
    accent-color: var(--primary-blue);
}

.forgot-link {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 500;
}

.forgot-link:hover {
    text-decoration: underline;
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
    }
    
    .feature-grid {
        display: none;
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
                <h1 class="brand-title">Parit Raja Rental</h1>
                <p class="brand-subtitle">Welcome back! Sign in to manage your properties and connect with tenants.</p>
                
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="feature-title">Property Management</div>
                        <div class="feature-desc">Manage all your rental properties in one place</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-title">Tenant Connect</div>
                        <div class="feature-desc">Connect with tenants and handle requests easily</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-title">Analytics</div>
                        <div class="feature-desc">Track your rental income and property performance</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form">
            <div class="form-header">
                <h2 class="form-title">Sign In</h2>
                <p class="form-subtitle">Enter your credentials to access your account</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i> Email Address
                    </label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email address" 
                           value="{{ old('email') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> Password
                    </label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" class="form-input" 
                               placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me for 30 days</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot your password?</a>
                </div>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>
            
            <div class="form-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one here</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}
</script>
@endsection