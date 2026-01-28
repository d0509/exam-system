@extends('admin.layout.master')
@isset($user)
    @section('title','Edit User')
@else
    @section('title','Create User')
@endisset
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">@isset($user)Edit User @else Create User @endisset</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Users</a>
        </div>
    </div>
    <div class="card-body px-4 py-4">
        @isset($user)
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        @else
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        @endisset
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ isset($user) ? $user->name : old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ isset($user) ? $user->email : old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                        value="{{ old('password') }}" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"
                        value="{{ old('password_confirmation') }}" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary shadow-sm mt-3">
                <i class="fas fa-save mr-2"></i> @isset($user)Update User @else Save User @endisset
            </button>
        </form>
    </div>
@endsection
@section('scripts')
@endsection
