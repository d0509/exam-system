@extends('student.layout.master')

@section('title', 'Student Home')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="text-center">
            <h1 class="mb-4">Welcome to Your Dashboard</h1>
            <a href="{{route('student.questions.index')}}" class="btn btn-primary btn-lg">Start Test</a>
        </div>
    </div>
@endsection
