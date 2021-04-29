<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
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
        $role = ['required', 'integer', 'exists:roles,id'];

        if (optional(Auth::user())->role_id != Role::ROLE_ADMIN_ID) {
            $role[] = 'not_in:' . Role::ROLE_ADMIN_ID;
        }

        return [
            'photo'             => ['sometimes', 'image'],
            'first_name'        => ['required', 'string:255'],
            'last_name'         => ['required', 'string:255'],
            'role_id'           => $role,
            'phone'             => ['nullable', 'regex:<^\+[\d]{1,3}\([\d]{3}\)[\d]{3}-[\d]{2}-[\d]{2}$>'],
            'email'             => ['required', 'string:255', 'email', Rule::unique('users')->ignore($this->user())],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            'organization'      => ['nullable', 'string:255'],
            'summary'           => ['nullable', 'string:255'],
        ];
    }

    
}
