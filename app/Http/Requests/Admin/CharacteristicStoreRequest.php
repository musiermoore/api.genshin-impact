<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CharacteristicStoreRequest extends FormRequest
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
            'name'                   => ['required', 'string'],
            'slug'                   => ['nullable', 'string', 'unique:characteristics,slug'],
            'in_percent'             => ['required', 'boolean'],
            'characteristic_type_id' => ['required', 'exists:characteristic_types,id']
        ];
    }
}
