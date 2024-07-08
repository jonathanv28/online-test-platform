@extends('layouts.homemain')

@php
    $enrolledTests = auth()->user()->results;
@endphp

@section('content')
    <div class="py-16 px-32">
        <div class="inline-flex mb-12">
            <h1 class="font-bold text-4xl">Hi, {{ auth()->user()->name }} 👋</h1>
            @if ($inProgressTest)
                <button
                    class="inline-flex items-center px-4 py-2 mx-7 text-sm font-medium text-center text-white bg-blue-700 rounded-lg"
                    type="button">
                    Your Test is Ongoing!
                </button>
            @else
                <button href="#"
                    class="inline-flex items-center px-4 py-2 mx-7 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200"
                    type="button" data-modal-target="addtest-modal" data-modal-toggle="addtest-modal" id="addtest-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="mr-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                        <path d="M15 12h-6" />
                        <path d="M12 9v6" />
                    </svg>
                    Add Test
                </button>
            @endif
        </div>
        <!-- Main modal -->
        <div id="addtest-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Test
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="addtest-modal" id="closetest-button">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-4">
                        <form id="addtest-form" class="space-y-4" action="/tests" method="POST">
                            @csrf
                            <div>
                                <label for="code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Test
                                    code</label>
                                <input type="text" name="code" id="code" autofocus
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Input Test Code" required />
                            </div>
                            <div class="flex justify-between">
                                <button type="submit"
                                    class="mb-6 w-full text-white bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($inProgressTest)
            <div data-aos="fade-up" data-aos-duration="650"
                class="max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded-t-lg object-cover h-56 mx-auto" src="{{ $inProgressTest->tests->image }}" alt=""
                    draggable="false" />
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $inProgressTest->tests->title }}</h5>
                    <div class="mb-4 lg:flex-col">
                        <div class="">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Test
                                is on going!</span>
                        </div>
                    </div>
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-200"
                        onclick="window.location.href='{{ route('tests.show', ['test' => $inProgressTest->test_id]) }}'">
                        Back to Test
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </div>
            </div>
        @else
            @if ($enrolledTests)
                <div class="grid grid-cols-3 xl:grid-cols-5 gap-6" id="test-list">
                    @foreach ($enrolledTests as $enrolled)
                        <div data-aos="fade-up" data-aos-duration="650"
                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="">
                                <img class="rounded-t-lg object-fill h-56 mx-auto" src="{{ $enrolled->tests->image }}"
                                    alt="" draggable="false" />
                            </div>
                            <div class="p-5">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ $enrolled->tests->title }}</h5>
                                <div class="mb-4 lg:flex-col">
                                    <div class="">
                                        @if ($enrolled->score || $enrolled->score === 0)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Test
                                                has been taken</span>
                                        @else
                                            <span
                                                class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Test
                                                has not been taken</span>
                                        @endif
                                    </div>
                                    <div class="">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Duration:
                                            {{ $enrolled->tests->duration }} minutes</span>
                                    </div>
                                </div>
                                @if ($enrolled->score || $enrolled->score === 0)
                                    <a href="{{ route('tests.result', $enrolled->tests->id) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center transition duration-200 text-white bg-blue-700 hover:bg-blue-900 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-200">View
                                        Result
                                    </a>
                                @else
                                    <button
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200"
                                        onclick="window.location.href='{{ route('tests.validate', $enrolled->tests->id) }}'">
                                        Start
                                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Message to display when there are no enrolled tests --}}
                <h2 class="mt-8 text-lg">No enrolled tests found. Start adding tests to start.</h2>
            @endif
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addTestButton = document.getElementById('addtest-button');
            const closeModalButton = document.getElementById('closetest-button');
            const modal = document.getElementById('addtest-modal');

            addTestButton.addEventListener('click', function() {
                modal.classList.remove('hidden');
                AOS.refresh(); // Reinitialize AOS to ensure animation plays
            });

            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            localStorage.removeItem('test_start_time');

        });
    </script>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-container');
            if (toast) {
                toast.classList.add('fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 1000);
            }
        }, 3000);
    </script>
@endsection
