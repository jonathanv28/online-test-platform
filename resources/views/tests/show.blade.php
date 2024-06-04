@extends('layouts.main')

@section('content')
<div class="test-container" data-duration="{{ $test->duration }}" id="test-container">
    <h1>{{ $test->title }}</h1>
    <div id="timer">00:00</div>
    <div id="question-nav">
        @foreach ($test->questions as $index => $question)
            <button class="question-nav-btn" data-question-index="{{ $index }}">{{ $index + 1 }}</button>
        @endforeach
    </div>
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
    <input type="hidden" id="testId" value="{{ $test->id }}" name="test_id">
    <!-- Video Stream -->
    <div class="flex justify-center items-center" style="max-width: 854px;">
        <video id="video" width="854" height="480" style="border-radius: 12px;" autoplay></video>
        <canvas id="canvas" width="854" height="480" style="display: none;"></canvas>
    </div>
    <button id="submit-test" type="button" class="btn btn-success">Submit Test</button>
</div>
<script src="{{ asset('js/test.js') }}"></script>
@endsection
