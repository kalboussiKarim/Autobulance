<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:staff'],
            'phone' => ['required', 'string'],
            'salary' => ['integer', 'min:0'],
            'position' => ['required', 'string'],
            'password' => ['required', 'confirmed'],
            'date_of_birth' => ['required', 'date'],
            'role' => ['required', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone must be a string.',
            'salary.integer' => 'The salary must be an integer.',
            'salary.min' => 'The salary must be at least :min.',
            'position.required' => 'The position field is required.',
            'position.string' => 'The position must be a string.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'The date of birth must be a valid date.',
            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a string.',

        ];
    }
}
