<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompatibilityParamRequest extends FormRequest
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
            'name.*' => ['required'],
            'group'  => ['required', 'exists:compatibility_param_groups,id'],
            'min_val' => ['required', 'integer', 'min:0'],
            'max_val' => ['required', 'integer', 'min:0'],
            'default_val' => ['required', 'integer', 'min:0'],
            'road_desc.*' => ['required'],
            'railway_desc.*' => ['required'],
            'energy_desc.*' => ['required'],
            'ict_desc.*' => ['required'],
            'other_desc.*' => ['required'],
        ];
    }
}
