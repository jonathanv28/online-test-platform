<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::latest()->paginate(10);
        $title = 'Manage Tests | Online Test Platform';
        return view('admin.tests.index', compact('tests', 'title'));
    }

    public function create()
    {
        $title = 'Create Test | Online Test Platform';
        return view('admin.tests.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:30',
            'code' => 'required|string|max:8|unique:tests,code',
            'image' => 'required|image',
            'duration' => 'required|integer|min:1|max:120'
        ]);

        $imagePath = $request->file('image')->store('tests', 's3');
        $imageUrl = Storage::disk('s3')->url($imagePath);

        $test = Test::create([
            'title' => $request->title,
            'code' => $request->code,
            'image' => $imageUrl,
            'duration' => $request->duration,
        ]);

        return redirect()->route('admin.tests.index')->with('success', 'Test created successfully. ');
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
        $title = 'Manage Tests | Online Test Platform';
        return view('admin.tests.edit', compact('test', 'title'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string|max:30',
            'code' => 'required|string|max:8|unique:tests,code,' . $test->id,
            'image' => 'sometimes|image',
            'duration' => 'required|integer|min:1|max:120'
        ]);

        // Handle the image upload if there's one
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tests', 's3');
            $test->image = Storage::disk('s3')->url($imagePath); // Set the new image URL to the test instance
        }

        // Update the rest of the test details
        $test->title = $request->title;
        $test->code = $request->code;
        $test->duration = $request->duration;
        $test->save(); // Persist the updated test to the database

        return redirect()->route('admin.tests.index')->with('success', 'Test has been updated. ');
    }

    public function destroy(Test $test)
    {
        DB::transaction(function () use ($test) {
            $test->results()->delete();
            $test->delete();
        });
        return redirect()->route('admin.tests.index')->with('success-delete', 'Test has been deleted. ');
    }

}
