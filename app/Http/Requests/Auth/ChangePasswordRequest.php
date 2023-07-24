<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password'     => 'required|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Kolom tidak boleh kosong',
            'password.required'     => 'Kolom tidak boleh kosong',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak sama',
            'password.min'          => 'Panjang minimal 8 karakter'
        ];
    }
}
