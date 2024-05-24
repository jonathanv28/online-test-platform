<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Result;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTestsRequest;
use App\Http\Requests\UpdateTestsRequest;
use Illuminate\Support\Facades\Log;

class TestsController extends Controller
{
    public function index()
    {
        //
    }

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
    public function show(Test $test)
    {
        $user = Auth::user();

        // Check if the user has already started the test
        $result = Result::where('user_id', $user->id)->where('test_id', $test->id)->first();
        if (!$result || !$result->start_time) {
            // Redirect to face validation if test not started
            return redirect()->route('tests.validate', ['test' => $test->id]);
        }

        // Check if the test has been completed
        if ($result->end_time || $result->score !== null) {
            return redirect()->route('home')->with('info', 'You have already completed this test.');
        }

        $questions = $test->questions()->with('answers')->get();

        return view('tests.show', [
            'test' => $test,
            'questions' => $questions,
            'totalQuestions' => $questions->count(),
            'title' => $test->title . ' | Online Test Platform'
        ]);
    }

    public function startTest(Test $test)
    {
        $user = Auth::user();

        // Start the test if not already started
        $result = Result::firstOrCreate(
            ['user_id' => $user->id, 'test_id' => $test->id],
            ['start_time' => now()]
        );

        return redirect()->route('tests.show', ['test' => $test->id]);
    }

    public function submit(Request $request, Test $test)
    {
        try {
            $user = Auth::user();
            $answers = $request->input('answers', []);
            Log::info('Submitted answers:', $answers);  // Log submitted answers
        
            // Initialize score
            $score = 0;
            foreach ($answers as $questionId => $answerId) {
                $answer = Answer::where('question_id', $questionId)
                                ->where('id', $answerId)
                                ->first();
        
                // Check if the answer is correct
                if ($answer && $answer->is_correct) {
                    $score++;
                }
            }
        
            // Calculate percentage score
            $totalQuestions = $test->questions()->count();
            $scorePercentage = ($score / $totalQuestions) * 100;
    
            Log::info('Calculated score:', ['score' => $scorePercentage]);  // Log the calculated score
        
            // Update the result with the score and end time
            Result::where('user_id', $user->id)->where('test_id', $test->id)
                ->update(['score' => $scorePercentage, 'end_time' => now()]);
    
        
            session()->forget('validated_for_test_' . $test->id);
    
            return response()->json(['success' => true, 'message' => 'Test submitted successfully.', 'testId' => $test->id]);
            return redirect()->route('tests.result', ['test' => $test->id])->with('clear_timer', true);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request', 'error' => $e->getMessage()], 500);
        }
    }

    protected function calculateResults($answers, Test $test)
    {
        $score = 0;
        foreach ($answers as $questionId => $answerId) {
            $question = $test->questions()->find($questionId);
            if ($question && $question->correct_answer == $answerId) {
                $score++;
            }
        }
        return $score;
    }

    public function result(Request $request, Test $test)
{
    $user = Auth::user();
    $result = Result::where('user_id', $user->id)->where('test_id', $test->id)->first();

    if (!$result) {
        return redirect()->route('home')->with('error', 'No result found for this test.');
    }

    return view('tests.result', [
        'result' => $result,
        'test' => $result->test,
        'user' => $user,
    ]);
}

    public function redirectToTestIfNeeded($user) {
        $ongoingTest = $user->results()->whereNull('end_time')->whereNotNull('start_time')->first();
        if ($ongoingTest) {
            return redirect()->route('tests.show', ['test' => $ongoingTest->test_id]);
        }
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
