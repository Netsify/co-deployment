<?php

namespace App\Http\Requests;

use App\Models\Variables\Variable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariableRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'unique:variables,slug'],
            'group' => ['required', 'exists:groups_of_variables,id'],
            'category' => ['required', 'exists:categories_of_variables,id'],
            'type' => ['required', Rule::in(Variable::VAR_TYPES)],
            'description.*' => ['required', 'max:255'],
            'unit.*' => ['required', 'max:255'],
            'min_val' => ['required', 'numeric', 'min:0'],
            'max_val' => ['required', 'numeric', 'min:0', 'gte:min_val'],
            'default_val' => ['required', 'numeric', 'min:0', 'gte:min_val', 'lte:max_val']
        ];
    }
}
