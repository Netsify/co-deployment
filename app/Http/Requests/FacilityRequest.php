<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityRequest extends FormRequest
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
            'title'       => ['required', 'min:8', 'max:500'],
            'location'    => ['required', 'min:8', 'max:255'],
            'description' => ['required'],
            'type'        => ['required', 'exists:facility_types,id'],
            'visibility'  => ['required', 'exists:facility_visibilities,id'],
            'length'      => ['required', 'numeric', 'min:0.001'],
            'c_param.*'   => ['required', 'integer']
        ];
    }
}
