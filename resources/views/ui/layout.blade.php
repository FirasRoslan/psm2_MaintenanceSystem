<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PSM2 System</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            overflow-x: hidden;
        }

        #sidebar {
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
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
            max-width: 1600px; /* Added max-width */
        }

        #content.expanded {
            margin-left: 0;
            width: 100%;
        }

        .content-wrapper {
            padding: 0 20px; /* Added padding */
            max-width: 1600px; /* Match content max-width */
            margin: 0 auto; /* Center the content */
        }

        .sidebar-link {
            padding: 10px 15px;
            color: #333;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .sidebar-link i {
            width: 25px;
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
            <div class="p-3">
                <h5 class="mb-4">PSM2 System</h5>
                @auth
                    @if(auth()->user()->isLandlord())
                        <a href="{{ route('landlord.dashboard') }}" class="sidebar-link mb-2">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('landlord.properties.index') }}" class="sidebar-link mb-2">
                            <i class="fas fa-building me-2"></i> Properties
                        </a>
                        <a href="#" class="sidebar-link mb-2">
                            <i class="fas fa-users me-2"></i> Tenants
                        </a>
                    @elseif(auth()->user()->isTenant())
                        <a href="{{ route('tenant.dashboard') }}" class="sidebar-link mb-2">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a href="#" class="sidebar-link mb-2">
                            <i class="fas fa-file-alt me-2"></i> Reports
                        </a>
                    @elseif(auth()->user()->isContractor())
                        <a href="{{ route('contractor.dashboard') }}" class="sidebar-link mb-2">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                        <a href="#" class="sidebar-link mb-2">
                            <i class="fas fa-tasks me-2"></i> Tasks
                        </a>
                    @endif
                @endauth
            </div>
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
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
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