@extends('ui.layout')

@section('title', 'Add Property')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Add New Property</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="house_address" class="form-label">Property Address</label>
                            <input type="text" class="form-control @error('house_address') is-invalid @enderror" 
                                   id="house_address" name="house_address" value="{{ old('house_address') }}" required>
                            @error('house_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="house_number_room" class="form-label">Number of Rooms</label>
                                <input type="number" class="form-control @error('house_number_room') is-invalid @enderror" 
                                       id="house_number_room" name="house_number_room" 
                                       value="{{ old('house_number_room', 1) }}" min="1" required>
                                @error('house_number_room')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="house_number_toilet" class="form-label">Number of Toilets</label>
                                <input type="number" class="form-control @error('house_number_toilet') is-invalid @enderror" 
                                       id="house_number_toilet" name="house_number_toilet" 
                                       value="{{ old('house_number_toilet', 1) }}" min="0" required>
                                @error('house_number_toilet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="house_image" class="form-label">Property Image</label>
                            <input type="file" class="form-control @error('house_image') is-invalid @enderror" 
                                   id="house_image" name="house_image" accept="image/jpeg,image/png,image/jpg" required>
                            @error('house_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Property</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    document.getElementById('house_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '100%';
                preview.style.maxHeight = '200px';
                preview.className = 'rounded';
                
                const previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = '';
                previewContainer.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush