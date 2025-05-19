<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Parit Raja Rental House</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-light: #e6f0ff;
            --primary-dark: #0a58ca;
            --secondary-color: #2c3e50;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            overflow-x: hidden;
        }

        #sidebar {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
            background-color: var(--light-gray);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #content {
            min-height: 100vh;
            transition: all 0.3s;
            margin-left: 250px;
            width: calc(100% - 250px);
            max-width: 1600px;
        }

        #content.expanded {
            margin-left: 0;
            width: 100%;
        }

        .content-wrapper {
            padding: 0 20px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .sidebar-brand {
            padding: 20px 15px;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }
        
        .sidebar-brand i {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.6rem;
        }

        .sidebar-link {
            padding: 12px 15px;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .sidebar-link.active {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .sidebar-link i {
            width: 25px;
            font-size: 1.1rem;
        }
        
        .sidebar-header {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
            padding: 15px 15px 5px;
            margin-top: 10px;
        }
        
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 20px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-home"></i>
                Parit Raja Rental
            </div>
            @include('ui.partials.sidebar')
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-light">
                        <i class="fas fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-user me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cog me-2"></i> Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
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
    
    <!-- ... other menu items ... -->
</ul>