@extends('ui.layout')

@section('title', 'Tenant Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Tenant Dashboard</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ auth()->user()->name }}</h5>
                    <p class="card-text">This is your tenant management dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection