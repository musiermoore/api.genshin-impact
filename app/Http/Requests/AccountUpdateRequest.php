<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'server_id'     => ['required', 'exists:servers,id'],
            'nickname'      => ['required', 'min:3', 'max:32', 'string'],
            'uid'           => ['required', 'numeric'],
            'level'         => ['required', 'min:1', 'max:60', 'numeric'],
            'world_level'   => ['required', 'min:1', 'max:8', 'numeric'],
            'gender'        => ['required', 'boolean']
        ];
    }
}
