@extends('layouts.main')

@php
    $enrolledTests = auth()->user()->results;
@endphp

@section('content')
<div class="py-16 px-32">
    @if(session()->has('success'))
    <div class="absolute top-4 mt-8 right-4 z-50">
        <div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">Item moved successfully.</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close" onclick="document.getElementById('toast-success').classList.add('hidden')">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div>
    @endif
        <div class="inline-flex mb-12">
            <h1 class="font-bold text-4xl">Hi, {{ auth()->user()->name }} 👋</h1>
            <button href="#"
                class="inline-flex items-center px-4 py-2 mx-7 text-sm font-medium text-center text-white bg-grass rounded-lg hover:bg-grassbold focus:ring-4 focus:outline-none focus:ring-green-200"
                type="button" data-modal-target="addtest-modal" data-modal-toggle="addtest-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                    <path d="M15 12h-6" />
                    <path d="M12 9v6" />
                </svg>
                Add Test
            </button>
        </div>
<!-- Main modal -->
<div id="addtest-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <!-- Dark overlay -->
    <div class="fixed inset-0 bg-black opacity-65"></div>

    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Test
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addtest-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="px-4">
                <form id="addtest-form" class="space-y-4" action="/tests" method="POST">
                    @csrf
                    <div>
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Test code</label>
                        <input type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Input Test Code" required />
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="mb-6 w-full text-white bg-grass hover:bg-grassbold focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        @if ($enrolledTests)
            <div class="grid grid-cols-5 gap-6">
                @foreach ($enrolledTests as $enrolled)
                    <div
                        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <img class="rounded-t-lg object-cover h-56" src="{{ asset('storage/' . $enrolled->tests->image) }}"
                            alt="" draggable="false" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $enrolled->tests->title }}</h5>
                            <div class="mb-4 lg:flex-col">
                                <div class="">
                                    @if ($enrolled->score)
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
                            @if ($enrolled->score)
                                <button href="#"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-400 rounded-lg focus:ring-4 focus:outline-none focus:ring-green-200"
                                    disabled>
                                    Score: {{ $enrolled->score }}
                                </button>
                            @else
                                <button href="#"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-grass rounded-lg hover:bg-grassbold focus:ring-4 focus:outline-none focus:ring-green-200">
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
    </div>
@endsection
