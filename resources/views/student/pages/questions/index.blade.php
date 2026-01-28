@extends('student.layout.master')
@section('title', 'Exam System | Exam')
@section('content')
<div class="container">
    <form action="{{ route('student.submit-exam') }}" method="POST" class="mt-5">
        @csrf
        @foreach ($questions as $question)
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{$question->question}}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($question->answers as $answer)
                        <li class="mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{$question->id}}" id="question_{{$question->id}}_{{$answer->id}}" value="{{$answer->id}}">
                                <label class="form-check-label" for="question_{{$question->id}}_{{$answer->id}}">
                                    {{$answer->answer}}
                                </label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
        <div class="d-grid gap-2 col-4 mx-auto mt-4">
            <button type="submit" class="btn btn-primary btn-lg mb-5">Submit Exam</button>
        </div>
    </form>
</div>
@endsection

