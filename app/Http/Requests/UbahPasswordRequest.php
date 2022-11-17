<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UbahPasswordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password_baru' => 'required|same:password_baru'
        ];
    }

    public function messages()
    {
        return [
            'password_lama.required' => 'Password Lama harus diisi',
            'password_baru.required' => 'Password Baru harus diisi',
            'password_baru.min' => 'Password Baru minimal 6 karakter',
            'konfirmasi_password_baru.required' => 'Konfirmasi Password Baru harus diisi',
            'konfirmasi_password_baru.same' => 'Konfirmasi Password Baru harus sama dengan Password Baru',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
