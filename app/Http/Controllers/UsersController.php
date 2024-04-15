<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:App\Models\User,email',
            'password' => 'required|max:255|confirmed|min:8',
            'idcard' => 'image|required|max:2048',
            'photo' => 'image|required|max:2048',
            'institute' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);

        $password =  Hash::make($request->password);
        $validatedData['password'] = $password;

        if ($request->file('idcard')) {
            $idcard = $request->file('idcard');
            $idcardName =  uniqid() . '.jpg';
            $idcard->storeAs('public/users', $idcardName);
            $validatedData['idcard'] = $idcard->storeAs('users', $idcardName);
        }

        if ($request->file('photo')) {
            $photo = $request->file('photo');
            $photoName =  uniqid() . '.jpg';
            $photo->storeAs('public/users', $photoName);
            $validatedData['photo'] = $photo->storeAs('users', $photoName);
        }

        User::create($validatedData);

        return redirect('/login')->with('success', 'Account successfully made');
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
