<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WeaponStoreRequest extends FormRequest
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
            'rarity_id'      => ['required', 'exists:rarities,id'],
            'name'           => ['required', 'string'],
            'slug'           => ['nullable', 'string', 'unique:weapons,slug'],
            'sub_stat_id'    => ['required', 'exists:characteristics,id'],
            'weapon_type_id' => ['required', 'exists:weapon_types,id'],
            'image'          => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'image_type_id'  => ['nullable', 'exists:image_types,id'],
            'description'    => ['required', 'string']
        ];
    }
}
