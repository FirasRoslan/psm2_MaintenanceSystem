@extends('ui.layout')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header -->
    <div class="property-header mb-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.properties.index') }}" class="text-decoration-none">
                        <i class="fas fa-building me-1"></i>Properties
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $house->house_address }}</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="property-title">
                    <i class="fas fa-home me-3"></i>{{ $house->house_address }}
                </h1>
                <div class="property-stats-inline">
                    <span class="stat-item">
                        <i class="fas fa-bed me-1"></i>{{ $house->house_number_room }} Rooms
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-bath me-1"></i>{{ $house->house_number_toilet }} Toilets
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-door-open me-1"></i>{{ $house->rooms->count() }} Rooms Added
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="property-actions">
                    <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Properties
                    </a>
                    <a href="{{ route('landlord.properties.rooms.create', $house->houseID) }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Add Room
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Property Image & Info -->
        <div class="col-lg-4 mb-4">
            <div class="property-info-card">
                <div class="property-image-container">
                    <img src="{{ asset('storage/' . $house->house_image) }}" 
                         class="property-main-image" 
                         alt="{{ $house->house_address }}">
                </div>
                <div class="property-info-content">
                    <div class="property-specs">
                        <div class="spec-item">
                            <div class="spec-icon rooms">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="spec-details">
                                <span class="spec-value">{{ $house->house_number_room }}</span>
                                <span class="spec-label">Rooms</span>
                            </div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-icon toilets">
                                <i class="fas fa-bath"></i>
                            </div>
                            <div class="spec-details">
                                <span class="spec-value">{{ $house->house_number_toilet }}</span>
                                <span class="spec-label">Toilets</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="property-danger-zone">
                        <h6 class="danger-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <p class="danger-description">This action cannot be undone.</p>
                        <form action="{{ route('landlord.properties.delete', $house->houseID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-modern w-100">
                                <i class="fas fa-trash me-2"></i>Delete Property
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rooms Section -->
        <div class="col-lg-8">
            <div class="rooms-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-door-open me-2"></i>Rooms ({{ $house->rooms->count() }})
                    </h4>
                    @if($house->rooms->count() > 0)
                        <a href="{{ route('landlord.properties.rooms.create', $house->houseID) }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Another Room
                        </a>
                    @endif
                </div>
                
                @if($house->rooms->count() > 0)
                    <div class="rooms-grid">
                        @foreach($house->rooms as $room)
                            <div class="room-card fade-in">
                                <div class="room-image-container">
                                    <img src="{{ asset('storage/' . $room->room_image) }}" 
                                         class="room-image" 
                                         alt="{{ $room->room_type }}">
                                    <div class="room-overlay">
                                        <div class="room-actions">
                                            <a href="{{ route('landlord.properties.rooms.show', $room->roomID) }}" 
                                               class="btn btn-sm btn-primary me-2">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                            <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" 
                                               class="btn btn-sm btn-light">
                                                <i class="fas fa-plus me-1"></i>Add Item
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="room-content">
                                    <div class="room-header">
                                        <h5 class="room-title">{{ $room->room_type }}</h5>
                                        <div class="room-meta">
                                            <span class="items-count">
                                                <i class="fas fa-cube me-1"></i>{{ $room->items->count() }} items
                                            </span>
                                        </div>
                                    </div>
                                    <div class="room-footer">
                                        <form action="{{ route('landlord.properties.rooms.delete', $room->roomID) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this room?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-rooms-state">
                        <div class="empty-state-content">
                            <div class="empty-state-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <h5 class="empty-state-title">No Rooms Added Yet</h5>
                            <p class="empty-state-description">Start by adding rooms to this property to manage items and maintenance.</p>
                            <a href="{{ route('landlord.properties.rooms.create', $house->houseID) }}" class="btn btn-modern-primary">
                                <i class="fas fa-plus me-2"></i>Add First Room
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.property-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.property-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.property-stats-inline {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    color: var(--text-muted);
    font-weight: 600;
    display: flex;
    align-items: center;
}

.property-info-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.property-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.property-main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-info-content {
    padding: 2rem;
}

.property-specs {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.spec-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.spec-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.spec-icon.rooms {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

.spec-icon.toilets {
    background: linear-gradient(135deg, #10b981, #059669);
}

.spec-details {
    display: flex;
    flex-direction: column;
}

.spec-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-color);
    line-height: 1;
}

.spec-label {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.property-danger-zone {
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
}

.danger-title {
    color: #dc2626;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.danger-description {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.btn-danger-modern {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    color: white;
}

.rooms-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin: 0;
}

.rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.room-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.room-image-container {
    position: relative;
    height: 160px;
    overflow: hidden;
}

.room-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.room-card:hover .room-image {
    transform: scale(1.05);
}

.room-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.room-card:hover .room-overlay {
    opacity: 1;
}

.room-content {
    padding: 1.5rem;
}

.room-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.room-meta {
    margin-bottom: 1rem;
}

.items-count {
    color: var(--text-muted);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
}

.empty-rooms-state {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 300px;
}

.empty-state-content {
    text-align: center;
    max-width: 300px;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.75rem;
}

.empty-state-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .property-stats-inline {
        gap: 1rem;
    }
    
    .property-specs {
        flex-direction: column;
        gap: 1rem;
    }
    
    .rooms-grid {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endsection