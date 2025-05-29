@extends('ui.layout')

@section('title', 'Submit Maintenance Report')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-2">Submit Maintenance Report</h2>
            <p class="text-muted mb-0 fs-5">Report maintenance issues in your assigned properties</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="fas fa-check-circle fa-lg text-success"></i>
            </div>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($houses->count() > 0)
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="icon-box bg-warning bg-opacity-10 p-4 rounded-3 d-inline-flex mb-3">
                            <i class="fas fa-tools text-warning fa-2x"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Report Maintenance Issue</h4>
                        <p class="text-muted">Please provide detailed information about the maintenance issue</p>
                    </div>

                    <form action="{{ route('tenant.reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Property Selection -->
                        <div class="mb-4">
                            <label for="houseID" class="form-label fw-bold text-dark">Select Property</label>
                            <select class="form-select rounded-3 border-2" id="houseID" name="houseID" required>
                                <option value="">Choose a property...</option>
                                @foreach($houses as $house)
                                    <option value="{{ $house->houseID }}">{{ $house->house_address }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Selection -->
                        <div class="mb-4">
                            <label for="roomID" class="form-label fw-bold text-dark">Select Room</label>
                            <select class="form-select rounded-3 border-2" id="roomID" name="roomID" required disabled>
                                <option value="">First select a property...</option>
                            </select>
                        </div>

                        <!-- Item Selection -->
                        <div class="mb-4">
                            <label for="itemID" class="form-label fw-bold text-dark">Select Item/Area</label>
                            <select class="form-select rounded-3 border-2" id="itemID" name="itemID" required disabled>
                                <option value="">First select a room...</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="report_desc" class="form-label fw-bold text-dark">Issue Description</label>
                            <textarea class="form-control rounded-3 border-2" id="report_desc" name="report_desc" rows="4" 
                                placeholder="Please describe the maintenance issue in detail..." required></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="report_image" class="form-label fw-bold text-dark">Upload Image</label>
                            <div class="upload-area border-2 border-dashed rounded-3 p-4 text-center">
                                <input type="file" class="form-control" id="report_image" name="report_image" 
                                    accept="image/jpeg,image/png,image/jpg" required style="display: none;">
                                <div class="upload-content" onclick="document.getElementById('report_image').click()">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h6 class="text-dark mb-2">Click to upload image</h6>
                                    <p class="text-muted mb-0">JPG, PNG files up to 2MB</p>
                                </div>
                                <div class="preview-area mt-3" style="display: none;">
                                    <img id="imagePreview" src="" alt="Preview" class="img-fluid rounded-3" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning rounded-pill px-5 py-3 fw-bold">
                                <i class="fas fa-paper-plane me-2"></i>Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="icon-box bg-light p-4 rounded-3 d-inline-flex mb-3">
            <i class="fas fa-home fa-3x text-muted"></i>
        </div>
        <h4 class="text-dark mb-3">No Assigned Properties</h4>
        <p class="text-muted mb-4">You need to have approved property assignments before submitting maintenance reports.</p>
        <a href="{{ route('tenant.find-houses') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-search me-2"></i>Find Properties
        </a>
    </div>
    @endif
</div>

<script>
// Dynamic form handling
document.getElementById('houseID').addEventListener('change', function() {
    const houseID = this.value;
    const roomSelect = document.getElementById('roomID');
    const itemSelect = document.getElementById('itemID');
    
    // Reset dependent selects
    roomSelect.innerHTML = '<option value="">Loading rooms...</option>';
    itemSelect.innerHTML = '<option value="">First select a room...</option>';
    itemSelect.disabled = true;
    
    if (houseID) {
        roomSelect.disabled = false;
        
        // Get rooms for selected house
        const houses = @json($houses);
        const selectedHouse = houses.find(house => house.houseID == houseID);
        
        if (selectedHouse && selectedHouse.rooms) {
            roomSelect.innerHTML = '<option value="">Choose a room...</option>';
            selectedHouse.rooms.forEach(room => {
                roomSelect.innerHTML += `<option value="${room.roomID}">${room.room_type}</option>`;
            });
        }
    } else {
        roomSelect.disabled = true;
        roomSelect.innerHTML = '<option value="">First select a property...</option>';
    }
});

document.getElementById('roomID').addEventListener('change', function() {
    const roomID = this.value;
    const itemSelect = document.getElementById('itemID');
    
    if (roomID) {
        itemSelect.disabled = false;
        itemSelect.innerHTML = '<option value="">Loading items...</option>';
        
        // Get items for selected room
        const houses = @json($houses);
        let selectedRoom = null;
        
        houses.forEach(house => {
            const room = house.rooms.find(r => r.roomID == roomID);
            if (room) selectedRoom = room;
        });
        
        if (selectedRoom && selectedRoom.items) {
            itemSelect.innerHTML = '<option value="">Choose an item/area...</option>';
            selectedRoom.items.forEach(item => {
                itemSelect.innerHTML += `<option value="${item.itemID}">${item.item_name}</option>`;
            });
        }
    } else {
        itemSelect.disabled = true;
        itemSelect.innerHTML = '<option value="">First select a room...</option>';
    }
});

// Image preview
document.getElementById('report_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.querySelector('.preview-area').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<style>
.upload-area {
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-area:hover {
    border-color: #ffc107 !important;
    background-color: #fff8e1;
}

.icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.form-select:focus,
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}
</style>
@endsection