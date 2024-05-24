@extends('layouts.main')

@section('content')
<div class="container mx-auto pt-16">
    <h1 class="text-center font-bold text-4xl mb-6">Face Validation for {{ $test->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <select id="camera-select" class="mx-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3.5 mb-6"></select>

    <div class="video-container mb-4 mx-auto" style="max-width: 854px;">
        <video id="video" width="854" height="480" style="border-radius: 12px;" autoplay></video>
        <canvas id="canvas" width="854" height="480" style="display:none; border-radius: 12px;"></canvas>
    </div>
    <div data-aos="fade-up" class="flex justify-center items-center gap-6">
        <button id="capture-and-validate" class="px-4 w-1/3 py-2 text-md font-medium text-center text-white bg-grass rounded-lg focus:outline-none hover:bg-grassbold focus:ring-4 focus:ring-green-200">
            Capture & Validate
        </button>
        <button id="start-test" class="px-4 w-1/5 py-2 text-md font-medium text-center text-gray-700 bg-gray-300 cursor-not-allowed rounded-lg focus:outline-none" disabled>
            Start Test
        </button>
    </div>
    <input type="hidden" id="testId" value="{{ $test->id }}">
</div>

<script src="{{ asset('js/validate.js') }}" defer></script>
@endsection
