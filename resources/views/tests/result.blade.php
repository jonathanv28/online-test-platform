@extends('layouts.main')

@section('content')
<div class="container mx-auto pt-16">
    <h1 class="text-center font-bold text-4xl mb-6">Test Results for {{ $test->title }}</h1>
    <div class="score-box">
        <p>Your score: {{ $result->score }}/{{ $test->questions->count() }}</p>
    </div>
    <div class="details">
        <p>Test taken on: {{ $result->start_time->format('d M Y H:i') }}</p>
        <p>Test completed on: {{ $result->end_time->format('d M Y H:i') }}</p>
        <p>Duration: {{ $result->start_time->diffInMinutes($result->end_time) }} minutes</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>

    @if(session('clear_timer'))
    <script>
        localStorage.removeItem('test_start_time');
    </script>
    @endif
</div>
@endsection
