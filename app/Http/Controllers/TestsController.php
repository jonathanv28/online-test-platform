<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTestsRequest;
use App\Http\Requests\UpdateTestsRequest;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // TestController.php

    public function validateFace(Test $test)
    {
        // Check if the test exists
        if (!$test) {
            abort(404, 'The test does not exist.');
        }

        // Check if the user is enrolled in this test
        $user = Auth::user();
        if (!$user->results->contains('test_id', $test->id)) {
            abort(403, 'You are not enrolled in this test.');
        }

        // Optionally check if the user has already passed face validation for this test session
        $sessionKey = 'validated_for_test_' . $test->id;
        if (session()->has($sessionKey)) {
            // Optionally redirect to the test page directly if already validated
            return redirect()->route('tests.show', ['test' => $test->id]);
        }

        // Show the face validation view
        return view('tests.validate', [
            'test' => $test,
            'title' => 'Validate | Online Test Platform',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTestsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $tests
     * @return \Illuminate\Http\Response
     */
    // Method to display the first question or a specific question
// public function show(Test $test, $questionNumber = null)
// {
//     $questions = $test->questions()->with('answers')->get();
//     if (!isset($questions[$questionNumber])) {
//         abort(404, 'Question does not exist.');
//     }

//     return view('tests.question', [
//         'test' => $test,
//         'question' => $questions[$questionNumber],
//         'questionNumber' => $questionNumber,
//         'totalQuestions' => count($questions)
//     ]);
// }

// public function show($testId)
// {
//     $test = Test::with(['questions.answers'])->find($testId);
//     if (!$test) {
//         abort(404);
//     }
//     return view('tests.show', [
//         'test' => $test,
//         'title' => $test->title . ' | Online Test Platform'  // Passing the title variable to the view
//     ]);
// }

public function show(Test $test, $questionNumber = 1)
{
    $questions = $test->questions()->with('answers')->get();
    if (!isset($questions[$questionNumber])) {
        abort(404, 'Question does not exist.');
    }

    return view('tests.show', [
        'test' => $test,
        'question' => $questions[$questionNumber],
        'questionNumber' => $questionNumber,
        'totalQuestions' => count($questions),
        'title' => $test->title . ' | Online Test Platform'
    ]);
}



// public function show(Test $test)
// {
//     $questions = $test->questions()->with('answers')->get();
//     return view('tests.show', [
//         'test' => $test,
//         'questions' => $questions,
//     ]);
// }

// Method to submit answers and calculate results
public function submit(Request $request, Test $test)
{
    $answers = $request->input('answers', []);
    $result = $this->calculateResults($answers, $test);

    // Optionally save results to the database or session
    session(['test_result' => $result]);

    return redirect()->route('tests.result', ['test' => $test->id]);
}

protected function calculateResults($answers, Test $test)
{
    $score = 0;
    foreach ($answers as $questionId => $answerId) {
        $question = Question::findOrFail($questionId);
        if ($question->correct_answer === $answerId) {
            $score++;
        }
    }
    return $score;
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $tests
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $tests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestsRequest  $request
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestsRequest $request, Test $tests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tests  $tests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $tests)
    {
        //
    }
}
