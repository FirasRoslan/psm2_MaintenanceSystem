<div class="p-3">
    <div class="text-center mb-4">
        <img src="{{ asset('image/logo.png') }}" 
             alt="Parit Raja Rental House" 
             class="img-fluid" 
             style="width: 200px; height: auto; margin-bottom: 10px;">
    </div>
    @auth
        @if(auth()->user()->isLandlord())
            <a href="{{ route('landlord.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a href="{{ route('landlord.properties.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.properties.*') ? 'active' : '' }}">
                <i class="fas fa-building me-2"></i> Properties
            </a>
            <a href="{{ route('landlord.tenants.index') }}" class="sidebar-link mb-2 {{ request()->routeIs('landlord.tenants.*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Tenants
            </a>
            <a href="#" class="sidebar-link mb-2">
                <i class="fas fa-clipboard-list me-2"></i> Requests
            </a>
            <a href="#" class="sidebar-link mb-2">
                <i class="fas fa-tasks me-2"></i> Tasks
            </a>
        @elseif(auth()->user()->isTenant())
            <a href="{{ route('tenant.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a href="#" class="sidebar-link mb-2">
                <i class="fas fa-file-alt me-2"></i> Reports
            </a>
        @elseif(auth()->user()->isContractor())
            <a href="{{ route('contractor.dashboard') }}" class="sidebar-link mb-2 {{ request()->routeIs('contractor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a href="#" class="sidebar-link mb-2">
                <i class="fas fa-tasks me-2"></i> Tasks
            </a>
        @endif
    @endauth
</div>