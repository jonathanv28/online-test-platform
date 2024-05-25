@extends('admin.layouts.main')

@section('content')
<div data-aos="fade-up" class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Manage Questions and Answers for <span class="underline decoration-blue-500">{{ $test->title }}</span>
                    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Manage the tests of the Online Test Platform here.</p>
                </caption>
                </div>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Question
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Option 1
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Option 2
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Option 3
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Option 4
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Correct Answer Option
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Delete</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test->questions as $question)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $question->question_text }}
                        </th>
                        @foreach ($question->answers as $answer)
                        <td class="px-6 py-4">
                            {{ $answer->option_text }} ({{ $answer->is_correct ? 'Correct' : 'Incorrect' }})
                        </td>
                        @endforeach
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Option {{ $question->correct_answer + 1 }}
                        </th>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection
