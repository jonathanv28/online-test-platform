<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You might want to add authorization logic here if needed
        return true; // Assuming every authenticated user can add tests
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|exists:tests,code', // Ensures the code exists in the tests table
        ];
    }

    /**
     * Get custom messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'A test code is required to add a test.',
            'code.exists' => 'The provided test code does not exist. Please check and try again.',
        ];
    }
}
