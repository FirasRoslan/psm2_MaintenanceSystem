<div class="p-3">
    <div class="text-center mb-4 sidebar-brand">
        <img src="{{ asset('image/logo2.png') }}" 
             alt="Parit Raja Rental House" 
             class="img-fluid sidebar-logo" 
             style="width: 100%; height: auto; max-width: 100%; object-fit: contain; margin-bottom: 10px;">
    </div>
    @auth
        @if(auth()->user()->isLandlord())
            <!-- Core Management Section -->
            <div class="sidebar-section mb-3">
                <h6 class="sidebar-section-title">Core Management</h6>
                <a href="{{ route('landlord.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('landlord.properties.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.properties.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span>Properties</span>
                </a>
                <a href="{{ route('landlord.tenants.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.tenants.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Tenants</span>
                </a>
            </div>
            
            <!-- Maintenance Section -->
            <div class="sidebar-section mb-3">
                <h6 class="sidebar-section-title">Maintenance</h6>
                <a href="{{ route('landlord.requests.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.requests.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Requests</span>
                </a>
                <a href="{{ route('landlord.contractors.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.contractors.*') ? 'active' : '' }}">
                    <i class="fas fa-hard-hat"></i>
                    <span>Contractors</span>
                </a>
                <a href="{{ route('landlord.tasks.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.tasks.*') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Tasks</span>
                </a>
            </div>
            
            <!-- Reports Section -->
            <div class="sidebar-section">
                <h6 class="sidebar-section-title">Reports</h6>
                <a href="{{ route('landlord.history.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.history*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>History</span>
                </a>
            </div>
            
        @elseif(auth()->user()->isTenant())
            <a href="{{ route('tenant.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('tenant.reports.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('tenant.reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
        @elseif(auth()->user()->isContractor())
            <a href="{{ route('contractor.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('contractor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('contractor.tasks') }}" class="sidebar-link mb-2 {{ request()->routeIs('contractor.tasks') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span>Tasks</span>
            </a>
        @endif
    @endauth
</div>

<style>
/* Custom scrollbar for sidebar */
#sidebar::-webkit-scrollbar {
    width: 6px;
}

#sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

#sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

#sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

.sidebar-section {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 0.75rem;
}

.sidebar-section:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.sidebar-section-title {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    padding-left: 0.5rem;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 0.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.sidebar-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateX(4px);
}

.sidebar-link.active {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.sidebar-link i {
    width: 20px;
    margin-right: 0.75rem;
    font-size: 1rem;
}

.sidebar-link span {
    font-size: 0.9rem;
}
</style>