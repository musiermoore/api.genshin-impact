<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeaponCharacteristicsSaveRequest extends FormRequest
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
            'level_id'     => ['required', 'integer', 'exists:levels,id'],
            'ascension_id' => ['required', 'integer', 'exists:ascensions,id'],
            'base_atk'     => ['required', 'numeric'],
            'sub_stat'     => ['required', 'numeric']
        ];
    }
}
