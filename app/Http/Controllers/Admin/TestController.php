<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        $title = 'Manage Tests | Online Test Platform';
        return view('admin.tests.index', compact('tests', 'title'));
    }

    public function create()
    {
        return view('admin.tests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'image' => 'required|image',
            'duration' => 'required|integer'
        ]);

        $imagePath = $request->file('image')->store('tests', 's3');
        $imageUrl = Storage::disk('s3')->url($imagePath);

        $test = Test::create([
            'title' => $request->title,
            'code' => $request->code,
            'image' => $imageUrl,
            'duration' => $request->duration,
        ]);

        return redirect()->route('admin.tests.index')->with('success', 'Test created successfully.');
    }

    public function show($id)
    {
        $test = Test::findOrFail($id);
        return view('admin.tests.show', [
            'test' => $test,
            'title' => "View Test | Online Test Platform"  // Add a custom title for the view
        ]);
    }

    public function edit(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'image' => 'image',
            'duration' => 'required|integer'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tests', 's3');
            $test->image = Storage::disk('s3')->url($imagePath);
        }

        $test->update($request->only(['title', 'code', 'duration']));

        return redirect()->route('admin.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Test deleted successfully.');
    }

    public function addQuestion(Request $request, Test $test)
{
    $request->validate([
        'question_text' => 'required|string',
        'correct_answer' => 'required|char',
        'options' => 'required|array',
        'options.*.text' => 'required|string',
        'options.*.is_correct' => 'required|boolean',
    ]);

    $question = $test->questions()->create([
        'question_text' => $request->question_text,
        'correct_answer' => $request->correct_answer,
    ]);

    foreach ($request->options as $option) {
        $question->answers()->create([
            'option_text' => $option['text'],
            'is_correct' => $option['is_correct'],
        ]);
    }

    return back()->with('success', 'Question added successfully.');
}

}
