@extends('layouts.main')

@section('content')
    <div class="container mx-auto pt-16">
        <h1 class="text-center font-bold text-4xl mb-8">Test Results for {{ $test->title }}</h1>
        <div data-aos="fade-up" data-aos-duration="650" 
            class="w-full max-w-screen-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-auto">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select tab</label>
                <select id="tabs"
                    class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option>Score</option>
                    <option>Info</option>
                    <option>Activity</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse"
                id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                <li class="w-full">
                    <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats"
                        aria-selected="true"
                        class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Score</button>
                </li>
                <li class="w-full">
                    <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about"
                        aria-selected="false"
                        class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Info</button>
                </li>
                <li class="w-full">
                    <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq"
                        aria-selected="false"
                        class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Activity</button>
                </li>
            </ul>
            <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel"
                    aria-labelledby="stats-tab">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-7xl font-extrabold">{{ $result->score }}</dt>
                        <dd class="text-gray-500 dark:text-gray-400">Out of 100</dd>
                    </div>
                </div>
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel"
                    aria-labelledby="about-tab">
                    <ol class="items-center sm:flex">
                        <li class="relative mb-6 sm:mb-0">
                            <div class="flex items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                      <svg class="w-4 h-4 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                      </svg>
                                      
                                </div>
                                <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                            </div>
                            <div class="mt-3 sm:pe-8">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Test Taken</h3>
                                <time
                                    class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">on
                                    {{ $result->start_time->setTimezone('Asia/Bangkok')->format('d M Y H:i:s') }} WIB</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">The {{ $test->title }}
                                    was taken by {{ $result->users->name }}</p>
                            </div>
                        </li>
                        <li class="relative mb-6 sm:mb-0">
                            <div class="flex items-center">
                                <div
                                    class="z-10 flex items-center justify-center w-6 h-6 bg-green-100 rounded-full ring-0 ring-white dark:bg-green-900 sm:ring-8 dark:ring-gray-900 shrink-0">
                                    <svg class="w-4 h-4 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                      </svg>
                                </div>
                                <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
                            </div>
                            <div class="mt-3 sm:pe-8">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Test Submitted</h3>
                                <time
                                    class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">on
                                    {{ $result->end_time->setTimezone('Asia/Bangkok')->format('d M Y H:i:s') }} WIB</time>
                                <p class="text-base font-normal text-gray-500 dark:text-gray-400">Test was submitted and
                                    completed in {{ $result->start_time->diffInMinutes($result->end_time) }} minutes.</p>
                            </div>
                        </li>
                    </ol>
                </div>
                <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="faq" role="tabpanel"
                    aria-labelledby="faq-tab">
                    <ol class="relative border-s border-gray-200 dark:border-gray-700 ms-6 mt-4">
                        @if($logs->isEmpty())
                        <li class="mb-10 ms-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <svg class="w-2.5 h-2.5 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10 10 0 0 0 10 0zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/>
                                    <path d="M13.73 6.27a1 1 0 0 0-1.41 0L10 8.59l-2.32-2.32a1 1 0 1 0-1.41 1.41L8.59 10l-2.32 2.32a1 1 0 0 0 1.41 1.41L10 11.41l2.32 2.32a1 1 0 0 0 1.41-1.41L11.41 10l2.32-2.32a1 1 0 0 0 0-1.41z"/>
                                </svg>
                            </span>
                            <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">No Suspicious Activity Detected</h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">The user did not perform any suspicious activities during the test.</p>
                        </li>
                        @else
                        @foreach ($logs as $log)
                        <li class="mb-10 ms-6">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-orange-100 rounded-full -start-3 ring-8 ring-white">
                                <svg class="w-4 h-4 text-orange-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                            </svg>
                            </span>
                            <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $log->reason }}</h3>
                            <time
                                class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $log->created_at->setTimezone('Asia/Bangkok')->format('d M Y H:i:s') }} WIB</time>
                        </li>
                        @endforeach
                        @endif
                    </ol>
                </div>
            </div>
        </div>
        <div class="mx-auto text-center mt-8" data-aos="fade-up" data-aos-duration="650" >
            <a href="{{ route('home') }}"
                class="mx-auto transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Back
                to Home</a>
        </div>
    </div>
@endsection
