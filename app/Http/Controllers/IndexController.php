<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    
    public function visitHome(){
        $enrolledTests = auth()->user()->results;
        dd($enrolledTests);
        return view('home', [
            'title' => 'Home | Online Test Platform',
            'active' => 'home',
            'enrolledTests' => $enrolledTests->tests
        ]);
    }
}
