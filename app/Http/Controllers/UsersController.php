<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
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
        return view('register', [
            'title' => 'Register | Online Test Platform',
            'active' => 'register'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $idcardUrl = $this->storeFile($request, 'idcard');
        $photoUrl = $this->storeFile($request, 'photo');
    
        if (!$idcardUrl || !$photoUrl) {
            return back()->withErrors('File upload failed. Please try again.')->withInput();
        }
    
        $validatedData['idcard'] = $idcardUrl;
        $validatedData['photo'] = $photoUrl;
    
        User::create($validatedData);

        return redirect('/login')->with('success', 'Account successfully created');
    }
    
    
    private function storeFile($request, $field) {
        if ($request->file($field)) {
            $file = $request->file($field);
            $filePath = 'users'; // Customize the path as needed.
            $fileName = uniqid() . '.jpg'; // Generate a unique file name.
    
            try {
                $path = Storage::disk('s3')->putFileAs($filePath, $file, $fileName, 'public');
                return Storage::disk('s3')->url($path);
            } catch (\Exception $e) {
                Log::error("Failed to upload $field: " . $e->getMessage());
                return null; // Or handle the error as appropriate.
            }
        }
        return null; // Return null if no file was uploaded.
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $users)
    {
        return view('profile', [
            'title' => 'Profile | Online Test Platform',
            'active' => 'Profile'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(User $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $users)
    {
        //
    }
}
