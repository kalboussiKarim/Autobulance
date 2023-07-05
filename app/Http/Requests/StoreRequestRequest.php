<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
            'client_id' => ['required'],
            'car_type' => ['required', 'string'],
            'matricule' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'longitude' => ['required', 'string'],
            'request_type' => ['required', 'string'],
            'date' => ['required', 'date'],
        ];
    }
    public function messages()
    {
        return [
            'client_id.required' => 'The client ID field is required.',
            'car_type.required' => 'The car type field is required.',
            'car_type.string' => 'The car type must be a string.',
            'matricule.required' => 'The matricule field is required.',
            'matricule.string' => 'The matricule must be a string.',
            'latitude.required' => 'The latitude field is required.',
            'latitude.string' => 'The latitude must be a string.',
            'longitude.required' => 'The longitude field is required.',
            'longitude.string' => 'The longitude must be a string.',
            'request_type.required' => 'The request type field is required.',
            'request_type.string' => 'The request type must be a string.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
        ];
    }
}
