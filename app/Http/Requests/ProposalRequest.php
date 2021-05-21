<?php

namespace App\Http\Requests;

use App\Rules\MaxUploadedFilesSizeRule;
use Illuminate\Foundation\Http\FormRequest;

class ProposalRequest extends FormRequest
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
            'description' => ['required', 'max:1000'],
            'attachments' => ['nullable', new MaxUploadedFilesSizeRule(config('services.max_available_filesize'))]
        ];
    }
}
