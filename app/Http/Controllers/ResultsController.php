<?php

namespace App\Http\Controllers;

use App\Models\Result;
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
     * @param  \App\Http\Requests\StoreResultsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultsRequest $request)
    {
        //
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
