@extends('ui.layout')

@section('title', 'Add New Property')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h4 class="mb-0">Add New Property</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="house_address" class="form-label">Property Address</label>
                            <input type="text" 
                                   class="form-control @error('house_address') is-invalid @enderror" 
                                   id="house_address" 
                                   name="house_address" 
                                   value="{{ old('house_address') }}" 
                                   required>
                            @error('house_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="house_number_room" class="form-label">Number of Rooms</label>
                                <input type="number" 
                                       class="form-control @error('house_number_room') is-invalid @enderror" 
                                       id="house_number_room" 
                                       name="house_number_room" 
                                       value="{{ old('house_number_room') }}" 
                                       min="1" 
                                       required>
                                @error('house_number_room')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="house_number_toilet" class="form-label">Number of Toilets</label>
                                <input type="number" 
                                       class="form-control @error('house_number_toilet') is-invalid @enderror" 
                                       id="house_number_toilet" 
                                       name="house_number_toilet" 
                                       value="{{ old('house_number_toilet') }}" 
                                       min="0" 
                                       required>
                                @error('house_number_toilet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="house_image" class="form-label">Property Image</label>
                            <input type="file" 
                                   class="form-control @error('house_image') is-invalid @enderror" 
                                   id="house_image" 
                                   name="house_image"
                                   accept="image/jpeg,image/png,image/jpg" 
                                   required>
                            <div class="form-text">Maximum file size: 2MB. Accepted formats: JPEG, PNG, JPG</div>
                            @error('house_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Property
                            </button>
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
    // Preview image before upload
    document.getElementById('house_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '100%';
                preview.style.marginTop = '10px';
                preview.className = 'rounded';
                
                const previewContainer = document.getElementById('house_image').parentNode;
                const existingPreview = previewContainer.querySelector('img');
                if (existingPreview) {
                    previewContainer.removeChild(existingPreview);
                }
                previewContainer.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush