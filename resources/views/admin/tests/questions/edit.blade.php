@extends('admin.layouts.main')

@section('content')
    <div data-aos="fade-up" class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-1/2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div
                    class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('admin.tests.questions.update', ['test' => $test->id, 'question' => $question->id]) }}" method="POST">
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
                                    <input type="text" id="answer_{{ $index }}" name="answers[{{ $answer->id }}][text]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $answer->option_text }}" required>

                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="correct_answer" value="{{ $answer->id }}"
                                                class="text-blue-600 border-gray-300"
                                                {{ ($question->correct_answer == ($answer->id % 4 != 0 ? $answer->id % 4 : $answer->id % 4 + 4)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600">Correct answer</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                <button type="submit"
                                    class="transition duration-200 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update
                                    Question
                                </button>
                            </div>
                    </form>
                    <form
                        action="{{ route('admin.tests.questions.destroy', ['test' => $test->id, 'question' => $question->id]) }}"
                        method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="focus:outline-none text-red-700 bg-white-700 hover:bg-red hover:text-white hover:bg-red-700 border border-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Delete Question
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
