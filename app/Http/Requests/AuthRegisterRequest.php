<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'login'     => ['required', 'min:3', 'max:32', 'string', 'unique:users,login'],
            'email'     => ['required', 'email', 'min:3', 'max:32', 'string', 'unique:users,email'],
            'name'      => ['required', 'min:3', 'max:32', 'string'],
            'gender'    => ['required', 'boolean'],
            'password'  => ['required', 'min:3', 'max:32', 'string', 'confirmed'],
        ];
    }
}
