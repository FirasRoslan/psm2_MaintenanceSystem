@extends('ui.layout')

@section('title', 'My Properties')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="page-title-section">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('landlord.dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active">My Properties</li>
                        </ol>
                    </nav>
                    <h1 class="page-title mb-2">
                        <i class="fas fa-building me-3"></i>My Properties
                    </h1>
                    <p class="page-subtitle mb-0">Manage and view all your rental properties</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="page-actions">
                    <a href="{{ route('landlord.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('landlord.properties.create') }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Add Property
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="properties-grid">
        @forelse($houses as $house)
            <div class="property-card fade-in">
                <div class="property-image-container">
                    <img src="{{ asset('storage/' . $house->house_image) }}" 
                         class="property-image" 
                         alt="{{ $house->house_address }}">
                    <div class="property-overlay">
                        <div class="property-stats">
                            <span class="stat-badge rooms">
                                <i class="fas fa-bed me-1"></i>{{ $house->house_number_room }} Rooms
                            </span>
                            <span class="stat-badge toilets">
                                <i class="fas fa-bath me-1"></i>{{ $house->house_number_toilet }} Toilets
                            </span>
                        </div>
                    </div>
                </div>
                <div class="property-content">
                    <div class="property-header">
                        <h5 class="property-title">{{ $house->house_address }}</h5>
                        <div class="property-meta">
                            <span class="meta-item">
                                <i class="fas fa-door-open me-1"></i>
                                {{ $house->rooms->count() }} rooms added
                            </span>
                        </div>
                    </div>
                    <div class="property-actions">
                        <a href="{{ route('landlord.properties.show', $house->houseID) }}" 
                           class="btn btn-property-action">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-content">
                    <div class="empty-state-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4 class="empty-state-title">No Properties Yet</h4>
                    <p class="empty-state-description">Start building your property portfolio by adding your first rental property.</p>
                    <a href="{{ route('landlord.properties.create') }}" class="btn btn-modern-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Add Your First Property
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--primary-dark);
}

.btn-modern-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: white;
}

.properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.property-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.property-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.property-image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.property-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.property-card:hover .property-image {
    transform: scale(1.05);
}

.property-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    display: flex;
    align-items: flex-end;
    padding: 1.5rem;
}

.property-stats {
    display: flex;
    gap: 0.5rem;
}

.stat-badge {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    color: var(--text-color);
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.property-content {
    padding: 1.5rem;
}

.property-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.property-meta {
    margin-bottom: 1.5rem;
}

.meta-item {
    color: var(--text-muted);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}

.btn-property-action {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-property-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    color: white;
}

.empty-state {
    grid-column: 1 / -1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
}

.empty-state-content {
    text-align: center;
    max-width: 400px;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.empty-state-description {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

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

@media (max-width: 768px) {
    .properties-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .page-actions {
        margin-top: 1rem;
    }
    
    .page-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection