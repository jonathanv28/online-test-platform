@extends('admin.layouts.main')

@section('content')
    <div data-aos="fade-up" class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 2xl:w-1/2 sm:w-4/5 lg:w-2/3">
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
                                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit
                                    Question</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div
                    class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form
                        action="{{ route('admin.tests.questions.update', ['test' => $test->id, 'question' => $question->id]) }}"
                        method="POST" id="edit-form">
                        @csrf
                        @method('PUT')
                        <div>
                            <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Question
                                for <span class="underline decoration-blue-500">{{ $test->title }}</span></h5>
                            <label for="question_text" class="block mb-2 text-sm font-normal text-gray-900">Question
                                Text</label>
                            <div class="relative mb-4">
                                <textarea id="question_text" name="question_text" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write your question here..." required>{{ old('question_text', $question->question_text) }}</textarea>
                            </div>

                            @foreach ($question->answers as $index => $answer)
                                <div class="mt-4">
                                    <label for="answer_{{ $index }}"
                                        class="block mb-2 text-sm font-normal text-gray-900">Option
                                        {{ $index + 1 }}</label>
                                    <input type="text" id="answer_{{ $index }}"
                                        name="answers[{{ $answer->id }}][text]"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        value="{{ $answer->option_text }}" required>

                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="correct_answer" value="{{ $answer->id }}"
                                                class="text-blue-600 border-gray-300"
                                                {{ $question->correct_answer == ($answer->id % 4 != 0 ? $answer->id % 4 : ($answer->id % 4) + 4) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Correct answer</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                <button type="submit" id="submit-edit-form"
                                    class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update
                                    Question
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
