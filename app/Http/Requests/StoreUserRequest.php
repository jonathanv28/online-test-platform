<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Make sure to handle authorization if needed
    }

    public function rules()
    {
        return [
            'name' => 'required|max:30',
            'email' => 'required|email:rfc,dns|unique:users,email|max:50',
            'password' => 'required|min:8|confirmed',
            'idcard' => 'image|required|max:2048',
            'photo' => 'image|required|max:2048',
            'institute' => 'required|max:30',
            'phone' => 'required|max:15',
        ];
    }
}

