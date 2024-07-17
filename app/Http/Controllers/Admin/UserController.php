<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Result;
use App\Models\Test;
use App\Models\CheckingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
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
            'name' => 'required|string|max:30',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|max:2048',
            'idcard' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'institute']);

        if ($request->hasFile('photo')) {
            $photoPath = $this->storeTempFile($request, 'photo');
            $photoUrl = $this->storeFileToS3($photoPath, 'users');
            if ($photoUrl) {
                $data['photo'] = $photoUrl;
                unlink($photoPath);
            } else {
                return back()->withErrors('Failed to upload photo. Please try again.')->withInput();
            }
        }

        if ($request->hasFile('idcard')) {
            $idcardPath = $this->storeTempFile($request, 'idcard');
            $idcardUrl = $this->storeFileToS3($idcardPath, 'users');
            if ($idcardUrl) {
                $data['idcard'] = $idcardUrl;
                unlink($idcardPath);
            } else {
                return back()->withErrors('Failed to upload ID card. Please try again.')->withInput();
            }
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function indexLogs()
    {
        $users = User::whereHas('results')->with('results')->orderBy('created_at', 'desc')->paginate(5);
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

    private function storeTempFile($request, $field)
    {
        if ($request->file($field)) {
            $file = $request->file($field);
            $tempPath = storage_path('app/temp/' . uniqid() . '.jpg');
            $file->move(dirname($tempPath), basename($tempPath));
            return $tempPath;
        }
        return null;
    }

    private function storeFileToS3($filePath, $directory)
    {
        try {
            $fileName = uniqid() . '.jpg';
            $path = Storage::disk('s3')->putFileAs($directory, new \Illuminate\Http\File($filePath), $fileName, 'public');
            return Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            Log::error("Failed to upload file to S3: " . $e->getMessage());
            return null;
        }
    }
}
