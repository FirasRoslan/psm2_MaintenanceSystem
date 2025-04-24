@extends('ui.layout')

@section('title', 'Add Item')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Add Item to {{ $room->room_type }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('landlord.properties.rooms.items.store', $room->roomID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="item_type" class="form-label">Item Type</label>
                            <select class="form-select @error('item_type') is-invalid @enderror" id="item_type" name="item_type" required>
                                <option value="">Select Item Type</option>
                                <option value="Furniture" {{ old('item_type') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Appliance" {{ old('item_type') == 'Appliance' ? 'selected' : '' }}>Appliance</option>
                                <option value="Electronics" {{ old('item_type') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Fixture" {{ old('item_type') == 'Fixture' ? 'selected' : '' }}>Fixture</option>
                                <option value="Other" {{ old('item_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('item_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control @error('item_name') is-invalid @enderror" 
                                   id="item_name" name="item_name" value="{{ old('item_name') }}" required>
                            @error('item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="item_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('item_quantity') is-invalid @enderror" 
                                   id="item_quantity" name="item_quantity" value="{{ old('item_quantity', 1) }}" min="1" required>
                            @error('item_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="item_image" class="form-label">Item Image</label>
                            <input type="file" class="form-control @error('item_image') is-invalid @enderror" 
                                   id="item_image" name="item_image" accept="image/jpeg,image/png,image/jpg" required>
                            @error('item_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landlord.properties.show', $room->house->houseID) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Item</button>
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
    document.getElementById('item_image').addEventListener('change', function(e) {
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