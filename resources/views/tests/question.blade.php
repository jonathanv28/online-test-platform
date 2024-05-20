@extends('layouts.main')

@section('content')
<div class="test-container">
    <h1>{{ $test->title }}</h1>
    <p>Question {{ $questionNumber + 1 }} of {{ $totalQuestions }}</p>
    <form method="POST" action="{{ route('tests.submit', ['test' => $test->id]) }}">
        @csrf
        <p>{{ $question->question_text }}</p>
        @foreach($question->answers as $answer)
            <label>
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}">
                {{ $answer->option_text }}
            </label>
        @endforeach
        <button type="submit">Submit</button>
    </form>
</div>
@endsection
