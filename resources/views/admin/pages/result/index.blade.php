@extends('admin.layout.master')
@section('title', 'Results')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Results</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="resultsTable">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>User</th>
                                    <th>Total Questions</th>
                                    <th>Correct Answers</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#resultsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.result.index') }}",
                    type: 'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user' },
                    { data: 'total_questions', name: 'total_questions' },
                    { data: 'correct_answers', name: 'correct_answers' },
                    { data: 'percentage', name: 'percentage' },
                ],
            });
        });
    </script>
@endpush

