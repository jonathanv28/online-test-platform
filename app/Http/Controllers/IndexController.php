<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Result;
use App\Models\Test;

class IndexController extends Controller
{
    
    public function visitHome(){
        $user = Auth::user();
        $inProgressTest = Result::where('user_id', $user->id)->where('status', 'in_progress')->first();
        $title = 'Home | Online Test Platform';
        $tests = Test::all(); // or however you get your tests

        return view('home', compact('inProgressTest', 'tests', 'title'));
    }
}
