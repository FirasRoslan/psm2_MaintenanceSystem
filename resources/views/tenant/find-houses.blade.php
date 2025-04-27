@extends('ui.layout')

@section('title', 'Find Properties')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Available Properties</h1>
                <a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="row">
                @if($houses->count() > 0)
                    @foreach($houses as $house)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $house->house_image) }}" class="card-img-top" alt="{{ $house->house_address }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $house->house_address }}</h5>
                                    <p class="card-text">
                                        <strong>Rooms:</strong> {{ $house->house_number_room }}<br>
                                        <strong>Bathrooms:</strong> {{ $house->house_number_toilet }}<br>
                                        <strong>Landlord:</strong> {{ $house->user->name }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('tenant.request-house') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="houseID" value="{{ $house->houseID }}">
                                        <button type="submit" class="btn btn-primary w-100">Request Assignment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            No properties are available at the moment. Please check back later.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection