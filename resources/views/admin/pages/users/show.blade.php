@extends('admin.layout.master')
@section('title', 'User Details')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Details</h1>
            <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Users
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
