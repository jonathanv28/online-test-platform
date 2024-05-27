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
    
        $questions = $test->questions()->with('answers')->get();
        $title = 'Manage QnA | Online Test Platform';
    
        return view('admin.tests.questions.index', compact('questions', 'title', 'test'));
    }

    public function create()
    {
        $tests = Test::all(); // Assuming questions are related to tests
        return view('admin.questions.create', compact('tests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string',
            'correct_answer' => 'required'
        ]);

        $question = new Question([
            'test_id' => $request->test_id,
            'question_text' => $request->question_text,
            'correct_answer' => $request->correct_answer
        ]);
        $question->save();

        return redirect()->route('admin.questions.index')->with('success', 'Question added successfully.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Test $test, Question $question)
    {
        // $test = Test::all(); // For dropdown list
        $title = 'Manage Question | Online Test Platform';
        return view('admin.tests.questions.edit', compact('question', 'test', 'title'));
    }

    // public function update(Request $request, Test $test, Question $question)
    // {
    //     $request->validate([
    //         'question_text' => 'required|string',
    //         'answers' => 'required|array',
    //         'correct_answer' => 'required|exists:answers,id',
    //     ]);
    
    //     $question->question_text = $request->question_text;
    //     $question->correct_answer = $request->correct_answer;
    //     $question->save();
    
    //     foreach ($request->answers as $id => $data) {
    //         $answer = Answer::find($id);
    //         $answer->option_text = $data['text'];
    //         $answer->save();
    //     }
    
    //     return redirect()->route('admin.tests.questions.index', $test->id)->with('success', 'Question updated successfully.');
    // }

//     public function update(Request $request, Test $test, Question $question)
// {
//     $request->validate([
//         'question_text' => 'required|string',
//         'answers' => 'required|array',
//         'correct_answer' => 'required|exists:answers,id',
//     ]);

//     // Update the question text
//     $question->question_text = $request->question_text;
//     $question->save();

//     // Update answers and set correct answer
//     foreach ($question->answers as $answer) {
//         // Update each answer's text
//         if (isset($request->answers[$answer->id])) {
//             $answer->option_text = $request->answers[$answer->id]['text'];
//             // Determine if this is the correct answer
//             $answer->is_correct = ($request->correct_answer == $answer->id);
//             $answer->save();
//         }
//     }

//     return redirect()->route('admin.tests.questions.index', ['test' => $question->test_id])->with('success', 'Question and answers updated successfully.');
// }

public function update(Request $request, Test $test, Question $question)
{
    $request->validate([
        'question_text' => 'required|string',
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
        $question->correct_answer = $correctAnswerId;
    }
    $question->save();

    return redirect()->route('admin.tests.questions.index', ['test' => $question->test_id])
                     ->with('success', 'Question and answers updated successfully.');
}

    

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}

