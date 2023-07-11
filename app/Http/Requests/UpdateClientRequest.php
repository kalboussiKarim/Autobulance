<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'full_name' => ['string', 'max:255'],
            'email' => ['email', 'unique:clients'],
            'phone' => ['string'],
            'password' => ['confirmed'/*, Password::defaults()*/],
            'date_of_birth' => ['date'],
            'gender' => ['in:male,female'],
        ];
    }

    public function messages()
    {

        return [
            //'full_name.required' => 'The full name field is required.',
            'full_name.string' => 'The full name must be a string.',
            'full_name.max' => 'The full name is too long.',
            //'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            //'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone must be a string.',
            //'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            //'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'The date of birth is not a valid date.',
            //'gender.required' => 'The gender field is required.',
            'gender.in' => 'The selected gender is invalid.',
        ];
    }
}
