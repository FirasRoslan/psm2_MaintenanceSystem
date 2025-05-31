<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Parit Raja Rental House</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-light: #e0e7ff;
            --primary-dark: #4f46e5;
            --secondary-color: #1f2937;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --text-color: #374151;
            --text-muted: #6b7280;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-color);
            background-color: var(--bg-light);
            line-height: 1.6;
        }

        /* Auth page specific styles */
        .auth-body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Top Header Styles */
        .top-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            height: 70px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            z-index: 999;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
        }

        .top-header.expanded {
            left: 80px;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            color: var(--text-color);
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .sidebar-toggle:hover {
            background: var(--bg-light);
            color: var(--primary-color);
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            background: none;
            border: none;
            padding: 0.5rem;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .profile-btn:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-md);
        }

        .profile-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .profile-dropdown.show .profile-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-color);
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-dropdown-item:last-child {
            border-bottom: none;
        }

        .profile-dropdown-item:hover {
            background: var(--bg-light);
            color: var(--primary-color);
        }

        .profile-dropdown-item i {
            margin-right: 0.75rem;
            width: 16px;
        }

        #sidebar {
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-right: none;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            overflow-x: hidden;
        }

        #sidebar.collapsed {
            width: 80px;
        }

        #sidebar.mobile-hidden {
            margin-left: -280px;
        }

        #content {
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 280px;
            margin-top: 70px;
            width: calc(100% - 280px);
            background-color: var(--bg-light);
        }

        #content.expanded {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        /* Auth page content - full width */
        #content.auth-content {
            margin-left: 0;
            margin-top: 0;
            width: 100%;
            min-height: 100vh;
        }

        .sidebar-brand {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar-brand img {
            max-width: 100%;
            height: auto;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        #sidebar.collapsed .sidebar-brand {
            padding: 1rem 0.5rem;
        }

        #sidebar.collapsed .sidebar-brand img {
            width: 40px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
            margin: 0.25rem 1rem;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar-link span {
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        #sidebar.collapsed .sidebar-link {
            padding: 1rem 0.75rem;
            justify-content: center;
            margin: 0.25rem 0.5rem;
        }

        #sidebar.collapsed .sidebar-link i {
            margin-right: 0;
        }

        #sidebar.collapsed .sidebar-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            background: white;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-bottom: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styles */
        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
        }

        /* Form Styles */
        .form-control {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        /* Table Styles */
        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table thead th {
            background: var(--bg-light);
            border: none;
            font-weight: 600;
            color: var(--text-color);
            padding: 1rem;
        }

        .table tbody td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--bg-light);
        }

        /* Badge Styles */
        .badge {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-weight: 600;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -280px;
                transition: margin-left 0.3s ease;
            }
            #sidebar.mobile-active {
                margin-left: 0;
            }
            .top-header {
                left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
        }

        /* Chart container styling */
        .chart-container {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>
@php
    $isAuthPage = request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*') || 
                  request()->is('login') || request()->is('register') || request()->is('password/*');
@endphp

<body class="@if($isAuthPage) auth-body @endif">
    
    @if(auth()->check() && !$isAuthPage)
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-gradient-primary">
            @include('ui.partials.sidebar')
        </div>

        <!-- Top Header -->
        <div class="top-header d-flex align-items-center justify-content-between px-4">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="profile-dropdown">
                <button class="profile-btn" onclick="toggleProfileDropdown()">
                    <i class="fas fa-user"></i>
                </button>
                <div class="profile-dropdown-menu">
                    <a href="{{ route('profile.show') }}" class="profile-dropdown-item">
                        <i class="fas fa-user-circle"></i>
                        Show Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="profile-dropdown-item w-100 text-start border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt"></i>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid p-0">
                @yield('content')
            </div>
        </div>
    </div>
    @else
    <!-- Auth pages content - no sidebar -->
    <div id="content" class="auth-content">
        @yield('content')
    </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleProfileDropdown() {
            const dropdown = document.querySelector('.profile-dropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.profile-dropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Sidebar toggle functionality
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const header = document.querySelector('.top-header');
            
            if (window.innerWidth <= 768) {
                // Mobile behavior - hide/show sidebar
                sidebar.classList.toggle('mobile-active');
            } else {
                // Desktop behavior - collapse/expand sidebar
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                header.classList.toggle('expanded');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const header = document.querySelector('.top-header');
            
            if (window.innerWidth > 768) {
                // Remove mobile classes on desktop
                if (sidebar) sidebar.classList.remove('mobile-active');
            } else {
                // Remove desktop classes on mobile
                if (sidebar) sidebar.classList.remove('collapsed');
                if (content) content.classList.remove('expanded');
                if (header) header.classList.remove('expanded');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>

<!-- Sidebar menu - This is a partial example of where to add the new menu item -->
<ul class="nav flex-column">
    <!-- Tenants menu item -->
    <li class="nav-item">
        <a href="{{ route('landlord.tenants.index') }}" class="nav-link {{ request()->routeIs('landlord.tenants.*') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i> Tenants
        </a>
    </li>
    
    <!-- Add the new Contractors menu item here, between Tenants and Requests -->
    <li class="nav-item">
        <a href="{{ route('landlord.tenants.index') }}" class="nav-link {{ request()->routeIs('landlord.tenants.*') ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i> Tenants
        </a>
    </li>
    
    <li class="nav-item">
        <a href="{{ route('landlord.contractors.index') }}" class="nav-link {{ request()->routeIs('landlord.contractors.*') ? 'active' : '' }}">
            <i class="fas fa-hard-hat me-2"></i> Contractors
        </a>
    </li>
    
    <li class="nav-item">
        <a href="{{ route('landlord.requests.index') }}" class="nav-link {{ request()->routeIs('landlord.requests.*') ? 'active' : '' }}">
            <i class="fas fa-tools me-2"></i> Requests
        </a>
    </li>
    
    <!-- Add this after the Tasks menu item in the sidebar -->
    <a href="{{ route('landlord.history.index') }}" class="nav-link {{ request()->routeIs('landlord.history.*') ? 'active' : '' }}">
        <i class="fas fa-history"></i> History
    </a>
</ul>
