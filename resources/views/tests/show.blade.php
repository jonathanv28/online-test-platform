@extends('layouts.main')

@section('content')
    <div id="popup-modal-submit" tabindex="-1" data-modal-backdrop="static"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal-submit" id="popup-modal-close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to submit
                        test?</h3>
                    <div class="mb-3">
                        <p class="items-center text-xs font-normal text-gray-500 dark:text-gray-400">Info: Any <span
                                class="font-bold">unanswered questions will be counted</span> towards the end score.</p>
                    </div>
                    <div class="inline-flex">
                        <button id="submit-test" type="button"
                            class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, Submit
                        </button>
                    </div>
                    <button data-modal-hide="popup-modal-submit" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                        cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div data-aos="fade-left" class="absolute top-4 mt-14 right-4 z-50" id="toast-checking">
        <div id="toast-for-checking"
            class="hidden flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                </svg>
                <span class="sr-only">Warning icon</span>
            </div>
            <div class="ms-3 text-sm font-normal" id="toast-checking-reason"></div>
        </div>
    </div>

    <div class="test-container container py-20 mx-auto" data-duration="{{ $test->duration }}" id="test-container">
        <div class="grid grid-cols-6 gap-6" data-aos="fade-up">
            <div class="col-span-4 flex place-items-center ">
                <h1 class="font-bold text-4xl">{{ $test->title }}</h1>
            </div>
            <div class="col-span-2 max-w-sm flex place-items-center justify-end">
                <div id="timer" class="text-white bg-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-end">00:00</div>
            </div>
            <div class="col-span-4">
                <div class="border-2 border-gray-200 border-dashed rounded-lg p-4">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-6 px-8">
                        <div id="question-container">
                            @foreach ($test->questions as $index => $question)
                                <h1 id="question-number" class="font-bold text-xl mb-6 text-left" style="{{ $index == 0 ? 'display: block;' : 'display: none;' }}">Question {{ $loop->iteration }}</h1>
                                <div class="question mb-4" data-question-id="{{ $question->id }}"
                                    style="{{ $index == 0 ? 'display: block;' : 'display: none;' }}">
                                    <p class="mb-4 font-light">{{ $question->question_text }}</p>
                                    @foreach ($question->answers as $answer)
                                        <div class="items-center mb-2">
                                            <input type="radio"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                name="answer[{{ $question->id }}]" value="{{ $answer->id }}"
                                                id="answer[{{ $answer->id }}]">
                                            <label for="answer[{{ $answer->id }}]"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $answer->option_text }}
                                            </label><br>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <button id="previous"
                            class="transition duration-200 text-blue-700 hover:text-white bg-white border border-blue-800 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2 focus:outline-none"
                            style="display: none;">Previous</button>
                        <button id="next"
                            class="transition duration-200 text-blue-700 hover:text-white bg-white border border-blue-800 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2 focus:outline-none">Next</button>
                        <button type="button" id="submit-test-dupe"
                            class="transition duration-200 text-green-700 hover:text-white bg-white border border-green-500 hover:bg-green-500 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-4 focus:outline-none"
                            data-modal-target="popup-modal-submit" data-modal-toggle="popup-modal-submit">Submit
                            Test</button>
                        <input type="hidden" id="testId" value="{{ $test->id }}" name="test_id">
                    </div>
                    </div>
            </div>
            <div class="col-span-2 flex flex-col items-start">
                <div class="flex justify-start items-start mb-4 aspect-video">
                    <video class="aspect-video object-cover max-w-sm h-auto mb-4" id="video" width="1280" height="720"
                        style="border-radius: 12px;" autoplay></video>
                    <canvas id="canvas" width="854" height="480" style="display: none;"></canvas>
                </div>
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow w-full" id="question-card">
                    <h1 class="font-bold text-xl mb-6 text-center">Questions List</h1>
                    <div id="question-nav" class="grid grid-cols-5 gap-2 px-4">
                        @foreach ($test->questions as $index => $question)
                            <button class="question-nav-btn text-center border border-gray-300 py-4 px-2 rounded-md"
                                data-question-index="{{ $index }}">{{ $index + 1 }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/test.js') }}"></script>
@endsection
