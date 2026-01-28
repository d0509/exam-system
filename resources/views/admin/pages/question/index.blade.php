@extends('admin.layout.master')
@section('title', 'Questions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #4e73df;
            color: #fff !important;
            border-color: #4e73df;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #eaecf4;
            color: #4e73df !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Questions</h1>
            <a href="{{ route('admin.questions.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm"></i> Add Question
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Questions List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="questions-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Marks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
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

            var table = $('#questions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.questions.index') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'question', name: 'question' },
                    { data: 'marks', name: 'marks' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Handle delete button click
            $('body').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this question?')) {
                    $.ajax({
                        url: '{{ url("admin/questions") }}/' + id,
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
