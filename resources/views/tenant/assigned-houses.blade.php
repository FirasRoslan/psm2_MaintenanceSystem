@extends('ui.layout')

@section('title', 'My Assigned Properties')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Properties</h1>
                <a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            
            @if($houses->count() > 0)
                <div class="row">
                    @foreach($houses as $house)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header 
                                    @if($house->pivot->approval_status === null) bg-warning text-dark
                                    @elseif($house->pivot->approval_status === true) bg-success text-white
                                    @else bg-danger text-white @endif">
                                    <h5 class="mb-0">
                                        @if($house->pivot->approval_status === null)
                                            Pending Approval
                                        @elseif($house->pivot->approval_status === true)
                                            Approved
                                        @else
                                            Rejected
                                        @endif
                                    </h5>
                                </div>
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
                                    @if($house->pivot->approval_status === true)
                                        <a href="{{ route('tenant.properties.show', $house->houseID) }}" class="btn btn-primary w-100">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    You don't have any property assignments yet. 
                    <a href="{{ route('tenant.find-houses') }}">Find a property</a> to request assignment.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection