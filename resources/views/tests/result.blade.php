@extends('layouts.main')

@section('content')
<div class="container mx-auto pt-16">
    <h1 class="text-center font-bold text-4xl mb-6">Test Results for {{ $test->title }}</h1>
    <div class="">
        <p>Your score: {{ $result->score }}</p>
    </div>
    <div class="mb-4">
        <p>Test taken on: {{ $result->start_time->format('d M Y H:i') }}</p>
        <p>Test completed on: {{ $result->end_time->format('d M Y H:i') }}</p>
        <p>Duration: {{ $result->start_time->diffInMinutes($result->end_time) }} minutes</p>
    </div>
    <a href="{{ route('home') }}" class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Go to Home</a>

    @if(session('clear_timer'))
    <script>
        localStorage.removeItem('test_start_time');
    </script>
    @endif
</div>
@endsection
