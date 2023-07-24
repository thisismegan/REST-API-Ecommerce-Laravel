<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'name'        => 'required',
            'city_id'     => 'required',
            'fullAddress' => 'required',
            'phoneNumber' => 'required|numeric'
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'         => 'Kolom nama tidak boleh kosong',
            'city_id.required'      => 'Anda belum memilih kota',
            'fullAddress.required'  => 'Kolom alamat tidak boleh kosong',
            'phoneNumber.required'  => 'Kolom No.HP tidak boleh kosong'
        ];
    }
}
