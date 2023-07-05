<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:services'],
            'price' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The service name is required',
            'name.unique' => 'The service already exists',
            'name.string' => 'The service name sould be a string',
            'price.required' => 'The service price is required',
            'price.integer' => 'The service price must be an integer',
        ];
    }
}
