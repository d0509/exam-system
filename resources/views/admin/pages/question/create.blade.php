@extends('admin.layout.master')
@isset($question)
    @section('title', 'Edit Question')
@else
@section('title', 'Create Question')
@endisset
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @isset($question)
                Edit Question
            @else
                Create Question
            @endisset
        </h1>
        <a href="{{ route('admin.questions.index') }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left"></i>
            Back to Questions</a>
    </div>

    <div class="card-body px-4 py-4">
        @isset($question)
            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
            @else
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                @endisset

                <div class="row">
                    <div class="col-md-6">
                        <label for="question">Question <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="4"
                            required>
@isset($question)
{{ $question->question }}@else{{ old('question') }}
@endisset
</textarea>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="marks">Marks <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('marks') is-invalid @enderror" id="marks"
                            name="marks"
                            value="@isset($question){{ $question->marks }}@else{{ old('marks') }}@endisset"
                            min="1" required>
                        @error('marks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status" value="1"
                                {{ old('status', true) ? 'checked' : '' }}>
                            <label class="form-check-label ml-1" for="status">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="form-check-label ml-1" for="status">
                        Option
                    </label>
                    <div id="options-wrapper">

                        @isset($question)
                            @foreach ($question->answers as $answer)
                                <div class="col-md-6 d-flex align-items-center mb-2">
                                    <input type="radio" name="correct_option" value="{{ $loop->index }}" class="mr-2"
                                        {{ $answer->is_correct ? 'checked' : '' }}>

                                    <input type="text" name="options[]" class="form-control mr-2"
                                        placeholder="Option {{ $loop->index + 1 }}" required
                                        value="{{ $answer->answer }}">
                                    @error('options')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-option"
                                        title="Remove">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 4; $i++)
                                <div class="col-md-6 d-flex align-items-center mb-2">
                                    <input type="radio" name="correct_option" value="{{ $i }}" class="mr-2">
                                    <input type="text" name="options[]" class="form-control mr-2"
                                        placeholder="Option {{ $i + 1 }}" required>
                                    @error('options')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-option"
                                        title="Remove">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endfor
                        @endisset
                    </div>
                    <button type="button" id="add-option" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-plus"></i> Add Option
                    </button>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-2"></i> Save Question
                    </button>
                </div>
            </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let optionIndex = 4;

    document.getElementById('add-option').addEventListener('click', function() {
        const wrapper = document.getElementById('options-wrapper');

        const row = document.createElement('div');
        row.className = 'col-md-6 d-flex align-items-center mb-2';

        row.innerHTML = `
            <input type="radio" name="correct_option" value="${optionIndex}" class="mr-2">
            <input type="text" name="options[]" class="form-control mr-2" placeholder="Option ${optionIndex + 1}" required>
            <button type="button" class="btn btn-sm btn-outline-danger remove-option">
                <i class="fas fa-trash"></i>
            </button>
        `;

        wrapper.appendChild(row);
        optionIndex++;
    });

    // Handle remove option button click
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-option')) {
            const removeButton = e.target.closest('.remove-option');
            const optionRow = removeButton.closest('.d-flex');
            if (optionRow) {
                optionRow.remove();
            }
        }
    });
</script>
@endpush
