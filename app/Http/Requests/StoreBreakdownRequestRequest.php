<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreakdownRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'request_id' => ['required', 'string'],
            'breakdown_id' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'request_id.required' => 'The request_id is required',
            'breakdown_id.required' => 'The breakdown_id is required',
        ];
    }
}
