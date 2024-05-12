@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-xl font-semibold mb-4">Face Validation Required</h1>
    <p class="mb-4">Please validate your identity to proceed with the test: <strong>{{ $test->title }}</strong>.</p>

    <!-- Camera Selection Dropdown -->
    <select id="camera-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 mb-4"></select>

    <div class="video-container mb-4">
        <video id="video" width="640" height="480" autoplay></video>
        <button id="capture" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Capture
        </button>
        <button id="process" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 hidden">
            Validate Face
        </button>
    </div>
    <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
</div>

<script src="{{ asset('js/validate.js') }}" defer></script>

@endsection