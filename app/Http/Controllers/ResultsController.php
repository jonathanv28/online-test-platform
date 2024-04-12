<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Requests\StoreResultsRequest;
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
        $request->validate([
            'code' => 'required|exists:tests,code'
        ]);

        $test = Test::where('code', $request->code)->first();

        if ($test) {
            $user = auth()->user();
            Result::create([
                'user_id' => $user->id,
                'test_id' => $test->id,
                'score' => null,
            ]);
            return redirect()->back()->with('success', 'Test added successfully!');
        } else {
            return redirect()->back()->with('error', 'Test with the provided code does not exist!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Results  $results
     * @return \Illuminate\Http\Response
     */
    public function show(Result $results)
    {
        //
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