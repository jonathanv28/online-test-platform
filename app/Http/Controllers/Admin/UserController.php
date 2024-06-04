<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Result;
use App\Models\Test;
use App\Models\CheckingLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $title = 'Manage Users | Online Test Platform';
        return view('admin.users.index', compact('users', 'title'));
    }

    public function edit(User $user)
    {
        $title = 'Edit User | Online Test Platform';
        return view('admin.users.edit', compact('user', 'title'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function indexLogs()
    {
        $users = User::with('results')->get();
        $title = 'Users Log | Online Test Platform';
        return view('admin.users.logs.index', compact('users', 'title'));
    }

    public function showLogs(User $user)
    {
        $results = Result::where('user_id', $user->id)->with('tests')->get();
        $title = 'User Logs | Online Test Platform';
        return view('admin.users.logs.show', compact('user', 'results', 'title'));
    }

public function showLogsFocus(User $user, Test $test)
    {
        $logs = CheckingLog::where('user_id', $user->id)->where('test_id', $test->id)->get();
        $title = 'Logs of ' . $user->name . ' | Online Test Platform';
        return view('admin.users.logs.logs', compact('logs', 'title', 'user', 'test'));
    }

}
