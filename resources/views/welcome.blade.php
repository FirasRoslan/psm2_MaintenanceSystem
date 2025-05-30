<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parit Raja Rental House</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|poppins:400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-light: #3b82f6;
            --primary-blue-dark: #1d4ed8;
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
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
            border-bottom: 1px solid var(--gray-200);
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue);
            text-decoration: none;
        }
        
        .navbar-brand:hover {
            color: var(--primary-blue-dark);
        }
        
        .nav-link {
            color: var(--gray-600);
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .nav-link:hover {
            color: var(--primary-blue);
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
            background-color: var(--primary-blue);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-blue-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
            color: var(--white);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }
        
        .btn-outline:hover {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        
        /* Hero Section */
        .hero-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--blue-50) 0%, var(--white) 100%);
            min-height: 90vh;
            display: flex;
            align-items: center;
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
        }
        
        .hero-image img {
            width: 100%;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-xl);
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
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--blue-200);
        }
        
        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
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
            background-color: var(--gray-50);
        }
        
        .role-card {
            background-color: var(--white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
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
            color: var(--primary-blue);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .role-link:hover {
            color: var(--primary-blue-dark);
        }
        
        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
            text-align: center;
            color: var(--white);
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
            color: var(--primary-blue);
            font-weight: 600;
        }
        
        .btn-white:hover {
            background-color: var(--gray-100);
            color: var(--primary-blue-dark);
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
            color: var(--primary-blue-light);
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
            background-color: var(--primary-blue);
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
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Landlord" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Landlords</h3>
                            <p>Are you an independent landlord managing your own properties? Make juggling your daily tasks easier and more organized.</p>
                            <a href="#" class="role-link">More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="role-card">
                        <div class="role-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Tenant" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Tenants</h3>
                            <p>Give tenants their own space with a separate portal built just for them. Tenants can collect rent online, manage maintenance requests, and more.</p>
                            <a href="#" class="role-link">More <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="role-card">
                        <div class="role-image">
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Contractor" class="img-fluid">
                        </div>
                        <div class="role-content">
                            <h3>Contractors</h3>
                            <p>Got a service professional you love working with? Invite them to sign up and assign requests and send payments inside the platform.</p>
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
                    <p>Simplifying property management for landlords and providing a better experience for tenants.</p>
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