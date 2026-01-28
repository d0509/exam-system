@extends('admin.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">User Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                             class="img-thumbnail rounded-circle"
                                             style="width: 200px; height: 200px; object-fit: cover;"
                                             alt="Profile Photo">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                             style="width: 200px; height: 200px; margin: 0 auto;">
                                            <span class="text-white display-4">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" name="profile_photo" id="profile_photo" class="d-none" onchange="this.form.submit()">
                                        <label for="profile_photo" class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="fas fa-camera"></i> Change Photo
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h3 class="mb-3">Personal Information</h3>
                                    <hr>
                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label fw-bold">Full Name:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label fw-bold">Email:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-sm-3 col-form-label fw-bold">Member Since:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext">{{ $user->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.profile.edit',[ $user->id]) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
