<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAutobulanceRequest extends FormRequest
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
            'matricule' => ['required', 'string', 'max:255', 'unique:autobulances'],
            'phone' => ['required', 'string', "max:255"],
        ];
    }
    public function messages()
    {
        return [
            'matricule.required' => 'The matricule field is required.',
            'matricule.unique' => 'This matricule already exists',
            'phone.required' => 'phone field is required.',
        ];
    }
}