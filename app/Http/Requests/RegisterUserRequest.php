<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:15',
            'lastName'  => 'required|max:15',
            'gender'    => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
        ];
    }
}
