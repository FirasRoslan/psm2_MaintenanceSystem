@extends('ui.layout')

@section('title', 'Room Details')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header -->
    <div class="room-header mb-4">
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
                <li class="breadcrumb-item">
                    <a href="{{ route('landlord.properties.show', $room->house->houseID) }}" class="text-decoration-none">
                        {{ $room->house->house_address }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $room->room_type }}</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="room-title">
                    <i class="fas fa-door-open me-3"></i>{{ $room->room_type }}
                </h1>
                <div class="room-stats-inline">
                    <span class="stat-item">
                        <i class="fas fa-cube me-1"></i>{{ $room->items->count() }} Items
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-home me-1"></i>{{ $room->house->house_address }}
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="room-actions">
                    <a href="{{ route('landlord.properties.show', $room->house->houseID) }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Property
                    </a>
                    <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" class="btn btn-modern-primary">
                        <i class="fas fa-plus me-2"></i>Add Item
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Room Image & Info -->
        <div class="col-lg-4 mb-4">
            <div class="room-info-card">
                <div class="room-image-container">
                    <img src="{{ asset('storage/' . $room->room_image) }}" 
                         class="room-main-image" 
                         alt="{{ $room->room_type }}">
                </div>
                <div class="room-info-content">
                    <div class="room-specs">
                        <div class="spec-item">
                            <div class="spec-icon items">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div class="spec-details">
                                <span class="spec-value">{{ $room->items->count() }}</span>
                                <span class="spec-label">Items</span>
                            </div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-icon room">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="spec-details">
                                <span class="spec-value">{{ $room->room_type }}</span>
                                <span class="spec-label">Room Type</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="room-danger-zone">
                        <h6 class="danger-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                        </h6>
                        <p class="danger-description">This action cannot be undone.</p>
                        <form action="{{ route('landlord.properties.rooms.delete', $room->roomID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-modern w-100">
                                <i class="fas fa-trash me-2"></i>Delete Room
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Items Section -->
        <div class="col-lg-8">
            <div class="items-section">
                <div class="section-header">
                    <h4 class="section-title">
                        <i class="fas fa-cube me-2"></i>Items ({{ $room->items->count() }})
                    </h4>
                    @if($room->items->count() > 0)
                        <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Another Item
                        </a>
                    @endif
                </div>
                
                @if($room->items->count() > 0)
                    <div class="items-grid">
                        @foreach($room->items as $item)
                            <div class="item-card fade-in">
                                <div class="item-image-container">
                                    <img src="{{ asset('storage/' . $item->item_image) }}" 
                                         class="item-image" 
                                         alt="{{ $item->item_name }}">
                                    <div class="item-type-badge">
                                        {{ $item->item_type }}
                                    </div>
                                </div>
                                <div class="item-content">
                                    <div class="item-header">
                                        <h5 class="item-title">{{ $item->item_name }}</h5>
                                        <div class="item-meta">
                                            <span class="item-condition {{ strtolower($item->item_condition) }}">
                                                <i class="fas fa-circle me-1"></i>{{ $item->item_condition }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($item->item_description)
                                        <p class="item-description">{{ $item->item_description }}</p>
                                    @endif
                                    <div class="item-footer">
                                        <form action="{{ route('landlord.properties.items.delete', $item->itemID) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this item?')">
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
                    <div class="empty-items-state">
                        <div class="empty-state-content">
                            <div class="empty-state-icon">
                                <i class="fas fa-cube"></i>
                            </div>
                            <h5 class="empty-state-title">No Items Added Yet</h5>
                            <p class="empty-state-description">Start by adding items to this room for better inventory management.</p>
                            <a href="{{ route('landlord.properties.rooms.items.create', $room->roomID) }}" class="btn btn-modern-primary">
                                <i class="fas fa-plus me-2"></i>Add First Item
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.room-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(99, 102, 241, 0.1);
}

.room-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.room-stats-inline {
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

.room-info-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.room-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.room-main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.room-info-content {
    padding: 2rem;
}

.room-specs {
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
    font-size: 1.2rem;
    color: white;
}

.spec-icon.items {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.spec-icon.room {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

.spec-details {
    display: flex;
    flex-direction: column;
}

.spec-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-primary);
}

.spec-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.room-danger-zone {
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.1);
    border-radius: 12px;
    padding: 1.5rem;
}

.danger-title {
    color: #dc2626;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.danger-description {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.items-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f8fafc;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.item-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.item-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.item-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.item-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-type-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.item-content {
    padding: 1.5rem;
}

.item-header {
    margin-bottom: 1rem;
}

.item-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.item-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.item-condition {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 6px;
}

.item-condition.excellent {
    background: rgba(34, 197, 94, 0.1);
    color: #059669;
}

.item-condition.good {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.item-condition.fair {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.item-condition.poor {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.item-description {
    color: var(--text-muted);
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.item-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.empty-items-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state-description {
    color: var(--text-muted);
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.btn-modern-primary {
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
    color: white;
}

.btn-danger-modern {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    color: white;
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
    .room-header {
        padding: 1.5rem;
    }
    
    .room-title {
        font-size: 1.5rem;
    }
    
    .room-stats-inline {
        gap: 1rem;
    }
    
    .room-specs {
        flex-direction: column;
        gap: 1rem;
    }
    
    .items-grid {
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