@extends('ui.layout')

@section('title', 'Properties')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Properties</h2>
        <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Property
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($houses as $house)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
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
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('landlord.properties.show', $house->houseID) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                            <form action="{{ route('landlord.properties.delete', $house->houseID) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this property?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <small class="text-muted">
                            <i class="fas fa-door-open me-2"></i>{{ $house->rooms->count() }} rooms added
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-home fa-4x text-muted mb-3"></i>
                        <h4>No Properties Yet</h4>
                        <p class="text-muted">Start by adding your first property</p>
                        <a href="{{ route('landlord.properties.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Property
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