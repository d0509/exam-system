@extends('admin.layout.master')
@section('title', 'Users')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
            <a href="{{ route('admin.users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm"></i> Add User
            </a>
        </div>
        <div class="card-body px-4 py-4">
            <table id="userTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            // Handle status toggle change
            $('body').on('change', '.user-status-toggle', function() {
                var status = $(this).prop('checked') ? 1 : 0;
                var user_id = $(this).data('user-id');
                $.ajax({
                    url: "{{ route('admin.users.updateStatus') }}",
                    method: 'POST',
                    data: {
                        user_id: user_id,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong!');
                    }
                });
            });

            // Handle delete button click
            $('body').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: '{{ url("admin/users") }}/' + id,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                table.draw();
                                toastr.success(response.message);
                            } else {
                                toastr.error('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error: ' + xhr.responseJSON?.message || 'Something went wrong!');
                        }
                    });
                }
            });
        });
    </script>
@endpush
