@extends('layouts.main')

@section('content')
<div class="test-container" data-duration="{{ $test->duration }}">
    <h1>{{ $test->title }}</h1>
    <div id="time">00:00</div>
    @foreach ($test->questions as $question)
        <div class="question" data-question-id="{{ $question->id }}" style="display: none;">
            <p>{{ $question->question_text }}</p>
            @foreach ($question->answers as $answer)
                <label>
                    <input type="radio" name="answer[{{ $question->id }}]" value="{{ $answer->id }}">
                    {{ $answer->option_text }}
                </label><br>
            @endforeach
        </div>
        @if ($questionNumber > 0)
            <a href="{{ route('tests.show', ['test' => $test->id, 'questionNumber' => $questionNumber - 1]) }}" class="btn btn-primary">Previous</a>
        @endif
        @if ($questionNumber < $totalQuestions - 1)
            <a href="{{ route('tests.show', ['test' => $test->id, 'questionNumber' => $questionNumber + 1]) }}" class="btn btn-primary">Next</a>
        @endif
    @endforeach
    <@if ($questionNumber == $totalQuestions - 1)
    <form method="post" action="{{ route('tests.submit', ['test' => $test->id]) }}">
        @csrf
        <button type="submit" class="btn btn-success">Submit Test</button>
    </form>
@endif
</div>
<script src="{{ asset('js/test.js') }}"></script>
@endsection
