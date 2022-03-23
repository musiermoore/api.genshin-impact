<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CharacterStoreRequest extends FormRequest
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
            'star_id'        => ['required', 'exists:stars,id'],
            'name'           => ['required', 'string'],
            'slug'           => ['nullable', 'string', 'unique:characters,slug'],
            'element_id'     => ['required', 'exists:elements,id'],
            'weapon_type_id' => ['required', 'exists:weapon_types,id'],
//            'image'          => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'image_type_id'  => ['nullable', 'exists:image_types,id']
        ];
    }
}
