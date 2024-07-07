@extends('layouts.main')

@section('content')
    <div class="container mx-auto pt-16">
        <h1 class="text-center font-bold text-4xl mb-6">Face Validation for {{ $test->title }}</h1>

        <select id="camera-select"
            class="mx-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-3.5 mb-6"></select>

        <div id="alertError" class="hidden flex w-2/5 p-4 mx-auto mb-6 text-red-700 bg-red-100 rounded-lg" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div id="validation-error-message" class="ml-3 text-sm font-medium">
            </div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8"
                data-dismiss-target="#alertError" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div id="alertSuccess" class="hidden flex w-2/5 p-4 mx-auto mb-4 text-green-800 bg-green-100 rounded-lg" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div id="validation-success-message" class="ms-3 text-sm font-medium">
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alertSuccess" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
            </button>
          </div>

        <div class="video-container mb-4 mx-auto" style="max-width: 854px;">
            <video id="video" width="854" height="480" style="border-radius: 12px;" autoplay></video>
            <canvas id="canvas" width="854" height="480" style="display:none; border-radius: 12px;"></canvas>
        </div>
        <div class="flex justify-center items-center gap-6 mb-4">
            <button id="capture-and-validate"
                class="px-4 w-1/3 py-2 text-md font-medium text-center text-white bg-blue-700 rounded-lg focus:outline-none hover:bg-blue-900 focus:ring-4 focus:ring-blue-200">
                Capture & Validate
            </button>
            <button id="start-test"
                class="px-4 w-1/5 py-2 text-md font-medium text-center text-gray-700 bg-gray-300 cursor-not-allowed rounded-lg focus:outline-none"
                disabled>
                Start Test
            </button>
        </div>
        <div data-aos="fade-up" class="w-2/5 mx-auto flex items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
              During the test, <span class="font-medium">navigating out of the test page</span> will result in <span class="font-medium">test progress lost</span> and you need to re-answer every question in the test.
            </div>
          </div>
        <input type="hidden" id="testId" value="{{ $test->id }}">
    </div>

    <script src="{{ asset('js/validate.js') }}" defer></script>
@endsection
