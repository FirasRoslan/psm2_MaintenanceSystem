@extends('ui.layout')
@section('title', 'Add Property')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header -->
    <div class="form-header mb-4">
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
                <li class="breadcrumb-item active">Add Property</li>
            </ol>
        </nav>
        <h1 class="form-title">
            <i class="fas fa-plus-circle me-3"></i>Add New Property
        </h1>
        <p class="form-subtitle">Create a new rental property in your portfolio</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-form-card">
                <div class="form-progress">
                    <div class="progress-step active">
                        <div class="step-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <span class="step-label">Property Details</span>
                    </div>
                </div>
                
                <form action="{{ route('landlord.properties.store') }}" method="POST" enctype="multipart/form-data" class="modern-form">
                    @csrf
                    
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-map-marker-alt me-2"></i>Property Information
                        </h5>
                        
                        <div class="form-group">
                            <label for="house_address" class="form-label">
                                <i class="fas fa-home me-2"></i>Property Address
                            </label>
                            <input type="text" 
                                   class="form-control modern-input @error('house_address') is-invalid @enderror" 
                                   id="house_address" 
                                   name="house_address" 
                                   value="{{ old('house_address') }}" 
                                   placeholder="Enter complete property address"
                                   required>
                            @error('house_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-th-large me-2"></i>Property Specifications
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="house_number_room" class="form-label">
                                        <i class="fas fa-bed me-2"></i>Number of Rooms
                                    </label>
                                    <input type="number" 
                                           class="form-control modern-input @error('house_number_room') is-invalid @enderror" 
                                           id="house_number_room" 
                                           name="house_number_room" 
                                           value="{{ old('house_number_room', 1) }}" 
                                           min="1" 
                                           placeholder="e.g., 3"
                                           required>
                                    @error('house_number_room')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="house_number_toilet" class="form-label">
                                        <i class="fas fa-bath me-2"></i>Number of Toilets
                                    </label>
                                    <input type="number" 
                                           class="form-control modern-input @error('house_number_toilet') is-invalid @enderror" 
                                           id="house_number_toilet" 
                                           name="house_number_toilet" 
                                           value="{{ old('house_number_toilet', 1) }}" 
                                           min="0" 
                                           placeholder="e.g., 2"
                                           required>
                                    @error('house_number_toilet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-camera me-2"></i>Property Image
                        </h5>
                        
                        <div class="form-group">
                            <label for="house_image" class="form-label">
                                Upload Property Photo
                            </label>
                            <div class="file-upload-area" id="fileUploadArea">
                                <input type="file" 
                                       class="form-control file-input @error('house_image') is-invalid @enderror" 
                                       id="house_image" 
                                       name="house_image" 
                                       accept="image/jpeg,image/png,image/jpg" 
                                       required>
                                <div class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Click to upload or drag and drop</p>
                                    <p class="upload-hint">PNG, JPG up to 10MB</p>
                                </div>
                                <div id="imagePreview" class="image-preview"></div>
                            </div>
                            @error('house_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="{{ route('landlord.properties.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-modern-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Add Property
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-header {
    text-align: center;
    margin-bottom: 3rem;
}

.form-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.form-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.modern-form-card {
    background: white;
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.form-progress {
    display: flex;
    justify-content: center;
    margin-bottom: 3rem;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.step-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.step-label {
    font-weight: 600;
    color: var(--primary-color);
}

.form-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.form-group {
    margin-bottom: 2rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    font-size: 1rem;
}

.modern-input {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.modern-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: white;
}

.file-upload-area {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: #fafafa;
}

.file-upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(99, 102, 241, 0.05);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.upload-text {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.upload-hint {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.image-preview {
    margin-top: 1rem;
    display: none;
}

.image-preview img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    border-radius: 12px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .modern-form-card {
        padding: 2rem 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>

@push('scripts')
<script>
// Image preview functionality
document.getElementById('house_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const placeholder = document.querySelector('.upload-placeholder');
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop functionality
const uploadArea = document.getElementById('fileUploadArea');
const fileInput = document.getElementById('house_image');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.style.borderColor = 'var(--primary-color)';
    uploadArea.style.background = 'rgba(99, 102, 241, 0.1)';
}

function unhighlight(e) {
    uploadArea.style.borderColor = '#d1d5db';
    uploadArea.style.background = '#fafafa';
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    
    // Trigger change event
    const event = new Event('change', { bubbles: true });
    fileInput.dispatchEvent(event);
}
</script>
@endpush
@endsection