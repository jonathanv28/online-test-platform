@extends('admin.layouts.main')

@section('content')
    <div data-aos="fade-up" class="p-4 sm:ml-64">
        <div
            class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 2xl:w-1/2 sm:w-4/5 lg:w-2/3">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <nav class="flex p-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('admin.tests.index') }}"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Manage
                                    Tests</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('admin.tests.questions.index', ['test' => $test->id]) }}"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $test->title }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Add
                                    Question</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div
                    class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('admin.tests.questions.store', $test->id) }}" method="POST" id="create-form">
                        @csrf
                        <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Add Question
                            for <span class="underline decoration-blue-500">{{ $test->title }}</span></h5>
                        <input type="hidden" name="test_id" value="{{ $test->id }}">
                        <label for="question_text" class="block mb-2 text-sm font-normal text-gray-900">Question
                            Text</label>
                        <div class="relative mb-4">
                            <textarea id="question_text" name="question_text" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write your question here..." required></textarea>
                        </div>

                        <div class="relative mb-4">
                            <label for="answer1" class="block mb-2 text-sm font-normal text-gray-900">Option 1: </label>
                            <input type="text" id="answer1" name="answers[]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>

                        <div class="relative mb-4">
                            <label for="answer2" class="block mb-2 text-sm font-normal text-gray-900">Option 2: </label>
                            <input type="text" id="answer2" name="answers[]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>

                        <div class="relative mb-4">
                            <label for="answer3" class="block mb-2 text-sm font-normal text-gray-900">Option 3: </label>
                            <input type="text" id="answer3" name="answers[]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>

                        <div class="relative mb-4">
                            <label for="answer4" class="block mb-2 text-sm font-normal text-gray-900">Option 4: </label>
                            <input type="text" id="answer4" name="answers[]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                        </div>

                        <div class="relative mb-4">
                            <label for="correct_answer" class="block mb-2 text-sm font-normal text-gray-900">Correct
                                Answer:</label>
                            <select name="correct_answer" id="correct_answer"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-3.5 py-2.5 mb-6"
                                required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>

                        </div>
                        <div class="">
                            <button type="submit" id="submit-create-form"
                                class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add
                                Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
