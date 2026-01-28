@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Account Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="mb-3">
                                                @if ($user->hasMedia('profile_photo'))
                                                    @foreach ($user->getMedia('profile_photo') as $media)
                                                         <img src="{{ $media->getUrl() }}"
                                                            class="img-thumbnail rounded-circle mb-3"
                                                            style="width: 200px; height: 200px; object-fit: cover;"
                                                            id="profile-photo-preview" alt="Profile Photo">
                                                    @endforeach
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-3"
                                                        style="width: 200px; height: 200px; margin: 0 auto;"
                                                        id="profile-photo-initial">
                                                        <span
                                                            class="text-white display-4">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <input type="file"
                                                        name="profile_photo"
                                                        id="profile_photo"
                                                        class="d-none"
                                                        accept="image/*"
                                                        onchange="handleFileSelect(this)">
                                                    <label for="profile_photo" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-camera"></i> Change Photo
                                                    </label>
                                                    <div class="file-info mt-1">
                                                        <small class="text-muted" id="file-name">No file chosen</small>
                                                    </div>
                                                    @error('profile_photo')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label fw-bold">Full Name</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label fw-bold">Email Address</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.update.password') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Change Password</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="current_password" class="form-label fw-bold">Current Password</label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label fw-bold">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password_confirmation" class="form-label fw-bold">Confirm New
                                            Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="change_password" value="1"
                                            class="btn btn-primary">
                                            <i class="fas fa-key"></i> Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function handleFileSelect(input) {
                if (input.files && input.files[0]) {
                    const fileName = input.files[0].name;
                    const fileNameEl = document.getElementById('file-name');
                    if (fileNameEl) fileNameEl.textContent = fileName;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Find the avatar column or wrapper
                        const col = input.closest('.col-md-4') || input.closest('.col-sm-4') || input.closest('.col') || input.closest('.mb-3');

                        // Remove any existing preview image(s) by id or class
                        const globalPreview = document.querySelectorAll('#profile-photo-preview, .profile-photo-preview');
                        globalPreview.forEach(el => el.remove());

                        // Remove any letter-avatar placeholders (divs with rounded-circle + bg-secondary)
                        const placeholders = document.querySelectorAll('.rounded-circle.bg-secondary, #profile-photo-initial');
                        placeholders.forEach(el => el.remove());

                        // If we found the column, also strip any img/placeholder inside it to be extra-safe
                        if (col) {
                            const imgs = col.querySelectorAll('img, .rounded-circle.bg-secondary, #profile-photo-initial');
                            imgs.forEach(i => i.remove());
                        }

                        // Create and insert a single new preview image
                        const img = document.createElement('img');
                        img.id = 'profile-photo-preview';
                        img.className = 'img-thumbnail rounded-circle mb-3 profile-photo-preview';
                        img.style.width = '200px';
                        img.style.height = '200px';
                        img.style.objectFit = 'cover';
                        img.src = e.target.result;
                        img.alt = 'Profile Preview';

                        // Insert the preview at the top of the closest wrapper or next to the input
                        const container = input.closest('.mb-3') || input.parentNode || col;
                        if (container) container.insertBefore(img, container.firstChild);
                        else input.parentNode.insertBefore(img, input);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
