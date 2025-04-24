@extends('ui.layout')

@section('title', 'My Properties')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Properties</h4>
        <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Property
        </a>
    </div>

    <div class="row">
        @forelse($houses as $house)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset('storage/' . $house->house_image) }}" 
                         class="card-img-top" 
                         alt="{{ $house->house_address }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $house->house_address }}</h5>
                        <div class="mb-3">
                            <span class="badge bg-info me-2">{{ $house->house_number_room }} Rooms</span>
                            <span class="badge bg-secondary">{{ $house->house_number_toilet }} Toilets</span>
                        </div>
                        <p class="card-text text-muted">
                            <small>{{ $house->rooms->count() }} rooms added</small>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('landlord.properties.show', $house->houseID) }}" class="btn btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-home fa-4x text-muted"></i>
                        </div>
                        <h5>No properties yet</h5>
                        <p class="text-muted">Add your first property to get started</p>
                        <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary px-4">
                            Add Property
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush