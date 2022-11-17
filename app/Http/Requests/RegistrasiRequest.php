<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrasiRequest extends FormRequest
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
            'nama' => 'required|min:3',
            'profesi' => 'required|min:3',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'profesi.required' => 'Profesi harus diisi',
            'profesi.min' => 'Profesi minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah tersedia',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.required' => 'Konfirmasi Password harus diisi',
            'konfirmasi_password.same' => 'Konfirmasi Password harus sama dengan Password',
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
