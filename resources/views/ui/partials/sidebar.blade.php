<div class="p-3">
    <div class="text-center mb-4 sidebar-brand">
        <img src="{{ asset('image/logo.png') }}" 
             alt="Parit Raja Rental House" 
             class="img-fluid" 
             style="width: 200px; height: auto; margin-bottom: 10px;">
    </div>
    @auth
        @if(auth()->user()->isLandlord())
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
            <a href="{{ route('landlord.contractors.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.contractors.*') ? 'active' : '' }}">
                <i class="fas fa-hard-hat"></i>
                <span>Contractors</span>
            </a>
            <a href="{{ route('landlord.requests.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.requests.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i>
                <span>Requests</span>
            </a>
            <a href="{{ route('landlord.tasks.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.tasks.*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span>Tasks</span>
            </a>
            <a href="{{ route('landlord.history.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.history*') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>History</span>
            </a>
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
            <a href="#" class="sidebar-link mb-2">
                <i class="fas fa-tasks"></i>
                <span>Tasks</span>
            </a>
        @endif
    @endauth
</div>