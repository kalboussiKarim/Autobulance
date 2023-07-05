<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreakdownRequest extends FormRequest
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
            'breakdown' => ['required', 'string', 'max:255', 'unique:breakdowns'],
        ];
    }
    public function messages()
    {
        return [
            'breakdown.required' => 'The disease field is required.',
            'breakdown.unique' => 'The disease field already exists.',
        ];
    }
}
