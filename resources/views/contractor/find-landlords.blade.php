@extends('ui.layout')

@section('title', 'Find Landlords')

@section('content')
<div class="dashboard-container">
    <!-- Enhanced Header Section -->
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-section">
                    <h1 class="dashboard-title mb-2">
                        <span class="greeting-text">Find Landlords</span>
                        <span class="search-emoji">🔍</span>
                    </h1>
                    <p class="dashboard-subtitle mb-0">
                        <i class="fas fa-building me-2"></i>
                        Browse landlords and request to be their maintenance contractor
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="dashboard-actions">
                    <a href="{{ route('contractor.dashboard') }}" class="btn btn-modern-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Welcome Alert -->
        <div class="welcome-alert mt-4">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="alert-text">
                    <h6 class="mb-1">Connect with Property Owners</h6>
                    <p class="mb-0">Find and connect with landlords who need reliable maintenance contractors for their properties.</p>
                </div>
            </div>
        </div>
        
        <!-- Search Section -->
        <div class="search-section mt-4">
            <div class="search-card">
                <div class="search-content">
                    <div class="search-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="search-input-wrapper">
                        <input type="text" id="landlordSearch" class="form-control search-input" placeholder="Search landlords by email address..." onkeyup="filterLandlords()">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon-danger me-3">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- Landlords Grid -->
    <div class="landlords-section">
        @if($landlords->count() > 0)
            <div class="row" id="landlordsGrid">
                @foreach($landlords as $landlord)
                    <div class="col-lg-4 col-md-6 mb-4 landlord-item" data-email="{{ strtolower($landlord->email) }}">
                        <div class="landlord-card">
                            <div class="card-header">
                                <div class="landlord-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="landlord-status">
                                    <span class="status-badge active">Active</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="landlord-name">{{ $landlord->name }}</h5>
                                <p class="landlord-email">
                                    <i class="fas fa-envelope me-2"></i>{{ $landlord->email }}
                                </p>
                                <div class="landlord-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-building"></i>
                                        <span>{{ $landlord->houses->count() ?? 0 }} Properties</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('contractor.landlord-properties', $landlord->userID) }}" class="btn btn-landlord-primary">
                                    <i class="fas fa-building me-2"></i>View Properties
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- No Results Message -->
            <div id="noResults" class="no-results" style="display: none;">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h6 class="empty-title">No Landlords Found</h6>
                    <p class="empty-text">No landlords match your search criteria. Try adjusting your search terms.</p>
                </div>
            </div>
        @else
            <div class="empty-state-main">
                <div class="empty-icon-main">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="empty-title-main">No Landlords Available</h5>
                <p class="empty-text-main">There are no landlords registered in the system yet. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* Modern Dashboard Styles */
.dashboard-container {
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
}

/* Header Styles */
.dashboard-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.greeting-text {
    display: inline-block;
}

.search-emoji {
    display: inline-block;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.dashboard-subtitle {
    color: #64748b;
    font-size: 1.1rem;
    font-weight: 500;
}

.btn-modern-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Welcome Alert */
.welcome-alert {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #c7d2fe;
}

.alert-content {
    display: flex;
    align-items: center;
}

.alert-icon {
    width: 48px;
    height: 48px;
    background: rgba(99, 102, 241, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #6366f1;
    font-size: 1.25rem;
}

.alert-text h6 {
    color: #3730a3;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-text p {
    color: #5b21b6;
    margin: 0;
}

/* Search Section */
.search-section {
    margin-top: 1.5rem;
}

.search-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.search-content {
    display: flex;
    align-items: center;
}

.search-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.25rem;
}

.search-input-wrapper {
    flex: 1;
}

.search-input {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8fafc;
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

/* Landlord Cards */
.landlords-section {
    margin-top: 2rem;
}

.landlord-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.landlord-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.landlord-avatar {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.landlord-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.status-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.2);
    color: #22c55e;
    border-color: rgba(34, 197, 94, 0.3);
}

.card-body {
    padding: 1.5rem;
    flex: 1;
}

.landlord-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.landlord-email {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.landlord-stats {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    color: #64748b;
    font-size: 0.9rem;
}

.stat-item i {
    margin-right: 0.5rem;
    color: #667eea;
}

.card-footer {
    padding: 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.btn-landlord-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    text-align: center;
}

.btn-landlord-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Modern Alert */
.modern-alert {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.1);
}

.alert-icon-danger {
    width: 40px;
    height: 40px;
    background: rgba(239, 68, 68, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
}

/* Empty States */
.empty-state, .empty-state-main {
    text-align: center;
    padding: 3rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.empty-icon, .empty-icon-main {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.empty-title, .empty-title-main {
    color: #1e293b;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-text, .empty-text-main {
    color: #64748b;
    margin: 0;
}

.no-results {
    margin-top: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .search-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-icon {
        margin-right: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
function filterLandlords() {
    const searchInput = document.getElementById('landlordSearch');
    const searchTerm = searchInput.value.toLowerCase();
    const landlordItems = document.querySelectorAll('.landlord-item');
    const noResults = document.getElementById('noResults');
    let visibleCount = 0;
    
    landlordItems.forEach(item => {
        const email = item.getAttribute('data-email');
        if (email.includes(searchTerm)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && searchTerm !== '') {
        noResults.style.display = 'block';
    } else {
        noResults.style.display = 'none';
    }
}

// Add some interactive animations
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.landlord-card');
    
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
    });
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
}
</style>
@endpush
@endsection