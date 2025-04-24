@extends('ui.layout')

@section('title', 'Add Room')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Add Room to {{ $house->house_address }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.properties.rooms.store', $house->houseID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type</label>
                            <select class="form-select @error('room_type') is-invalid @enderror" id="room_type" name="room_type" required>
                                <option value="">Select Room Type</option>
                                <option value="Living Room" {{ old('room_type') == 'Living Room' ? 'selected' : '' }}>Living Room</option>
                                <option value="Bedroom" {{ old('room_type') == 'Bedroom' ? 'selected' : '' }}>Bedroom</option>
                                <option value="Kitchen" {{ old('room_type') == 'Kitchen' ? 'selected' : '' }}>Kitchen</option>
                                <option value="Bathroom" {{ old('room_type') == 'Bathroom' ? 'selected' : '' }}>Bathroom</option>
                                <option value="Dining Room" {{ old('room_type') == 'Dining Room' ? 'selected' : '' }}>Dining Room</option>
                                <option value="Study Room" {{ old('room_type') == 'Study Room' ? 'selected' : '' }}>Study Room</option>
                                <option value="Laundry Room" {{ old('room_type') == 'Laundry Room' ? 'selected' : '' }}>Laundry Room</option>
                                <option value="Other" {{ old('room_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('room_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="room_image" class="form-label">Room Image</label>
                            <input type="file" class="form-control @error('room_image') is-invalid @enderror" 
                                   id="room_image" name="room_image" accept="image/jpeg,image/png,image/jpg" required>
                            @error('room_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.properties.show', $house->houseID) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Room</button>
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
    document.getElementById('room_image').addEventListener('change', function(e) {
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