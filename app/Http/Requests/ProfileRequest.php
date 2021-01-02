<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'photo'             => ['nullable'],
            'first_name'        => ['string:255'],
            'last_name'         => ['string:255'],
            'role'              => ['required', 'integer', 'exists:roles,id'],
            'phone'             => ['nullable', 'integer'],
            'email'             => ['string:255', 'email', Rule::unique('users')->ignore($this->user())],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            'organization'      => ['nullable', 'string:255'],
            'summary'           => ['nullable', 'string:255'],
        ];
    }
}
