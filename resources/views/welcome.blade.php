<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parit Raja Rental House - UTHM Students</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|poppins:400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-sky: #0ea5e9;
            --primary-sky-light: #38bdf8;
            --primary-sky-dark: #0284c7;
            --sky-50: #f0f9ff;
            --sky-100: #e0f2fe;
            --sky-200: #bae6fd;
            --sky-300: #7dd3fc;
            --sky-400: #38bdf8;
            --sky-500: #0ea5e9;
            --sky-600: #0284c7;
            --sky-700: #0369a1;
            --sky-800: #075985;
            --sky-900: #0c4a6e;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --uthm-gold: #fbbf24;
            --uthm-gold-light: #fcd34d;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--gray-800);
            line-height: 1.6;
            background-color: var(--white);
        }
        
        /* Navigation */
        .navbar {
            padding: 1rem 0;
            background-color: var(--white);
            border-bottom: 1px solid var(--sky-200);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-sky);
            text-decoration: none;
        }
        
        .navbar-brand:hover {
            color: var(--primary-sky-dark);
        }
        
        .nav-link {
            color: var(--gray-600);
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .nav-link:hover {
            color: var(--primary-sky);
        }
        
        .btn {
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-sky), var(--primary-sky-light));
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-sky-dark), var(--primary-sky));
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
            color: var(--white);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary-sky);
            border: 2px solid var(--primary-sky);
        }
        
        .btn-outline:hover {
            background-color: var(--primary-sky);
            color: var(--white);
        }
        
        /* Hero Section */
        .hero-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--sky-50) 0%, var(--white) 50%, var(--sky-100) 100%);
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23e0f2fe" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.5;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }
        
        .hero-content p {
            font-size: 1.25rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        
        .hero-image {
            position: relative;
            z-index: 2;
        }
        
        .hero-image img {
            width: 100%;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-xl);
        }
        
        /* UTHM Welcome Section */
        .uthm-welcome-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--primary-sky), var(--sky-600));
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .uthm-welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 40%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(15deg);
            border-radius: 50%;
        }
        
        .uthm-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }
        
        .uthm-logo {
            width: 80px;
            height: 80px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: var(--shadow-lg);
        }
        
        .uthm-logo i {
            font-size: 2rem;
            color: var(--primary-sky);
        }
        
        .uthm-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .uthm-content p {
            font-size: 1.125rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        
        .uthm-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--uthm-gold);
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Feature Cards */
        .feature-section {
            padding: 5rem 0;
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }
        
        .section-title p {
            font-size: 1.125rem;
            color: var(--gray-600);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .feature-card {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--sky-200);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--sky-300);
        }
        
        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, var(--primary-sky), var(--primary-sky-light));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .feature-icon i {
            font-size: 1.5rem;
            color: var(--white);
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }
        
        .feature-card p {
            color: var(--gray-600);
            line-height: 1.6;
        }
        
        /* Roles Section */
        .roles-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--sky-50), var(--gray-50));
        }
        
        .role-card {
            background-color: var(--white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid var(--sky-200);
        }
        
        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--sky-300);
        }
        
        .role-image {
            height: 250px;
            overflow: hidden;
        }
        
        .role-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .role-card:hover .role-image img {
            transform: scale(1.05);
        }
        
        .role-content {
            padding: 2rem;
        }
        
        .role-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }
        
        .role-content p {
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .role-link {
            color: var(--primary-sky);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .role-link:hover {
            color: var(--primary-sky-dark);
        }
        
        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary-sky), var(--sky-600));
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -30%;
            left: -20%;
            width: 40%;
            height: 160%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(-15deg);
            border-radius: 50%;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
        }
        
        .cta-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-content p {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-white {
            background-color: var(--white);
            color: var(--primary-sky);
            font-weight: 600;
        }
        
        .btn-white:hover {
            background-color: var(--sky-50);
            color: var(--primary-sky-dark);
            transform: translateY(-2px);
        }
        
        /* Footer */
        .footer {
            padding: 3rem 0 2rem;
            background-color: var(--gray-900);
            color: var(--gray-200);
        }
        
        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1rem;
        }
        
        .footer-links h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 1rem;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: var(--gray-200);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .footer-links a:hover {
            color: var(--sky-400);
        }
        
        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-icons a {
            width: 2.5rem;
            height: 2.5rem;
            background-color: var(--gray-800);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-200);
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .social-icons a:hover {
            background-color: var(--primary-sky);
            color: var(--white);
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-800);
            margin-top: 2rem;
            color: var(--gray-600);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content {
                text-align: center;
                margin-bottom: 3rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .cta-content h2 {
                font-size: 2rem;
            }
            
            .uthm-content h2 {
                font-size: 2rem;
            }
            
            .uthm-stats {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-home me-2" style="font-size: 1.5rem;"></i>
                Parit Raja Rental
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roles">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#uthm">UTHM Students</a>
                    </li>
                </ul>
                <div class="ms-lg-3 mt-3 mt-lg-0 d-flex gap-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Everything You Need to Manage Your Properties</h1>
                    <p>Easily manage rental maintenance, track reports from tenants, and assign tasks to contractors – all online, anytime.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1073&q=80" alt="Property Management" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- UTHM Welcome Section -->
    <section class="uthm-welcome-section" id="uthm">
        <div class="container">
            <div class="uthm-content">
                <div class="uthm-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>Welcome UTHM Students!</h2>
                <p>Specially designed for Universiti Tun Hussein Onn Malaysia students living in Parit Raja. We understand your unique needs as students and provide the best rental house management experience tailored just for you.</p>
                
                <div class="uthm-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">UTHM Students</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Houses Available</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-section" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Simplify Your Property Management</h2>
                <p>Our platform offers everything you need to manage your rental properties efficiently</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>Maintenance Reporting</h3>
                        <p>Tenants can easily report issues like plumbing or electrical problems. Reports include descriptions and photos, helping landlords take quick action.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Task Assignment</h3>
                        <p>Landlords can assign maintenance tasks directly to contractors and monitor progress in real-time for better task tracking and accountability.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3>Property Management</h3>
                        <p>Landlords can add and update property details such as address, facilities provided, and tenant info for easier portfolio tracking.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>Notification System</h3>
                        <p>Instant notifications keep landlords, tenants, and contractors informed about task updates, new reports, and system alerts.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Maintenance History</h3>
                        <p>Every completed task is stored in the history module, helping landlords review past issues and improve future property maintenance.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-lock"></i>
                        </div>
                        <h3>User Roles Access</h3>
                        <p>Role-based login for Landlords, Tenants, and Contractors ensures each user sees only the tools they need to use, making the system simple and secure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section class="roles-section" id="roles">
        <div class="container">
            <div class="section-title">
                <h2>Built for Every User</h2>
                <p>Our platform is designed to serve different user roles with tailored features and interfaces</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="role-card">
                        <div class="role-image">
                            <img src="https://plus.unsplash.com/premium_photo-1664475082823-45a186f569b1?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Landlord" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Landlords</h3>
                            <p>Manage your rental properties with ease. Add your property, receive maintenance reports from tenants, and assign tasks directly to contractors — all in one place.</p>
                            <a href="#" class="role-link">More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="role-card">
                        <div class="role-image">
                            <img src="https://images.unsplash.com/photo-1652946619064-a12aec2d8456?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Tenant" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Tenants</h3>
                            <p>Easily report any house issues like leaking pipes or broken lights. Upload photos, track progress, and get notified when the problem is fixed.</p>
                            <a href="#" class="role-link">More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="role-card">
                        <div class="role-image">
                            <img src="https://plus.unsplash.com/premium_photo-1664299069577-11579b487e6c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Contractor" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Contractors</h3>
                            <p>Get assigned to maintenance tasks by landlords. Update task status, communicate directly, and complete jobs efficiently through the system.</p>
                            <a href="#" class="role-link">More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Streamline Your Property Management?</h2>
                <p>A web-based system that helps landlords manage property maintenance, track tenant requests, and assign tasks to contractors – all in one place.</p>
                <a href="{{ route('register') }}" class="btn btn-white">Get Started Today</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">
                        <i class="fas fa-home me-2"></i> Parit Raja Rental
                    </div>
                    <p>Simplifying property management for landlords and providing a better experience for tenants, especially UTHM students.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our Team</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h4>Features</h4>
                        <ul>
                            <li><a href="#">Property Listings</a></li>
                            <li><a href="#">Tenant Management</a></li>
                            <li><a href="#">Maintenance</a></li>
                            <li><a href="#">Reporting</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="footer-links">
                        <h4>Contact Us</h4>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Parit Raja, Johor, Malaysia</li>
                            <li><i class="fas fa-phone-alt me-2"></i> +60 12-345-6789</li>
                            <li><i class="fas fa-envelope me-2"></i> info@paritrajamental.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Parit Raja Rental House. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>