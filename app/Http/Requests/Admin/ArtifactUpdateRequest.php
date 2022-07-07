<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArtifactUpdateRequest extends FormRequest
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
            'artifact_set_id' => ['required', 'exists:artifact_sets,id'],
            'name'            => ['required', 'string'],
            'slug'            => ['nullable', 'string', Rule::unique('artifacts')->ignore($this->id)]
        ];
    }
}
