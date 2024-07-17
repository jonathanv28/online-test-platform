<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Test $test)
    {
        if (!$test) {
            abort(404, 'Test not found');
        }

        $questions = $test->questions()->with('answers')->paginate(5);
        $title = 'Manage QnA | Online Test Platform';

        return view('admin.tests.questions.index', compact('questions', 'title', 'test'));
    }

    public function create(Test $test)
    {
        $title = 'Add Question | Online Test Platform';
        return view('admin.tests.questions.create', compact('test', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string|max:255',
            'answers' => 'required|array',
            'correct_answer' => 'required|integer|min:1|max:4' // Assuming there are always four answers
        ]);

        // Create the new question with a temporary null for correct_answer
        $question = new Question([
            'test_id' => $request->input('test_id'),
            'question_text' => $request->input('question_text'),
            'correct_answer' => 0  // Temporarily set to null
        ]);
        $question->save(); // Save the question to generate an ID for answers

        // Create and save answers
        $answers = $request->input('answers');
        $correctAnswerIndex = $request->input('correct_answer') - 1;
        $correctAnswerId = null;

        foreach ($answers as $index => $answerText) {
            $answer = new Answer([
                'question_id' => $question->id,
                'option_text' => $answerText,
                'is_correct' => ($index === $correctAnswerIndex)
            ]);
            $answer->save();
            if ($index === $correctAnswerIndex) {
                $correctAnswerId = ($answer->id % 4 != 0 ? $answer->id % 4 : $answer->id % 4 + 4);
            }
        }

        $question->correct_answer = $correctAnswerId;
        $question->save();

        return redirect()->route('admin.tests.questions.index', ['test' => $question->test_id])
            ->with('success', 'Question and answers added successfully.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Test $test, Question $question)
    {
        $title = 'Manage Question | Online Test Platform';
        return view('admin.tests.questions.edit', compact('question', 'test', 'title'));
    }

    public function update(Request $request, Test $test, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'answers' => 'required|array',
            'correct_answer' => 'required|integer|exists:answers,id',
        ]);

        // Start by updating the question text
        $question->question_text = $request->question_text;

        // Initialize a variable to keep track of the correct answer
        $correctAnswerId = null;

        // Update answers and determine correct answer
        foreach ($question->answers as $answer) {
            if (isset($request->answers[$answer->id])) {
                $answer->option_text = $request->answers[$answer->id]['text'];
                // Check if this is the correct answer
                $answer->is_correct = ($request->correct_answer == $answer->id);
                $answer->save();

                // If this is the correct answer, store its ID
                if ($answer->is_correct) {
                    $correctAnswerId = $answer->id;
                }
            }
        }

        // Update the correct answer ID in the question model
        if ($correctAnswerId !== null) {
            $question->correct_answer = ($correctAnswerId % 4 != 0 ? $correctAnswerId % 4 : $correctAnswerId % 4 + 4);
        }
        $question->save();

        return redirect()->route('admin.tests.questions.index', ['test' => $question->test_id])
            ->with('success', 'Question and answers have been updated. ');
    }

    public function destroy(Test $test, Question $question)
    {
        $question->delete();
        return redirect()->route('admin.tests.questions.index', ['test' => $question->test_id])->with('success-delete', 'Question has been deleted. ');
    }
}
