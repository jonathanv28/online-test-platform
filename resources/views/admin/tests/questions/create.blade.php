@extends('admin.layouts.main')

@section('content')
    <div data-aos="fade-up" class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-1/2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div
                    class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('admin.tests.questions.store', $test->id) }}" method="POST">
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-3.5 py-2.5 mb-6" required>
                                <option value="" disabled selected>Select Option</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                            
                        </div>
                        <div class="">
                            <button type="submit"
                                class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add
                                Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
