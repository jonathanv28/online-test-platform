@extends('layouts.main')

@section('content')
<div class="test-container" data-duration="{{ $test->duration }}" id="test-container">
    <h1>{{ $test->title }}</h1>
    <div id="time">00:00</div>
    <div id="question-container">
        @foreach ($test->questions as $index => $question)
        <div class="question" data-question-id="{{ $question->id }}" style="{{ $index == 0 ? 'display: block;' : 'display: none;' }}">
            <p>{{ $question->question_text }}</p>
            @foreach ($question->answers as $answer)
                <label>
                    <input type="radio" name="answer[{{ $question->id }}]" value="{{ $answer->id }}">
                    {{ $answer->option_text }}
                </label><br>
            @endforeach
        </div>
        @endforeach
    </div>
    <button id="previous" class="btn btn-primary" style="display: none;">Previous</button>
    <button id="next" class="btn btn-primary">Next</button>
    <form id="submit-test" method="post" action="{{ route('tests.submit', ['test' => $test->id]) }}" style="display: none;">
        @csrf
        <button type="submit" class="btn btn-success">Submit Test</button>
    </form>
</div>
<script src="{{ asset('js/test.js') }}"></script>
@endsection
