<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateResultsRequest;

class ResultsController extends Controller
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
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $test = Test::whereRaw('BINARY `code` = ?', [$request->code])->first();

        if (!$test) {
            return redirect()->back()->with('error', 'The provided test code does not exist!');
        }

        $existingResult = Result::where('user_id', auth()->id())->where('test_id', $test->id)->first();

        if ($existingResult) {
            return redirect()->back()->with('error', 'You have already added this test!');
        }
    
        Result::create([
            'user_id' => auth()->id(),
            'test_id' => $test->id,
            'score' => null,
            'status' => null,
        ]);
    
        return redirect()->back()->with('success', 'Test added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Results  $results
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        $user = Auth::user();
        $result = Result::where('user_id', $user->id)->where('test_id', $test->id)->firstOrFail();

        return view('results.show', [
            'test' => $test,
            'result' => $result,
            'title' => 'Results | Online Test Platform'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Results  $results
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResultsRequest  $request
     * @param  \App\Models\Results  $results
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResultsRequest $request, Result $results)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Results  $results
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $results)
    {
        //
    }
}
