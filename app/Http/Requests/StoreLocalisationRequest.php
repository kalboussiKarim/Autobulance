<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocalisationRequest extends FormRequest
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
            'latitude' =>['required','string','max:255'] , 
            'longitude'=>['required','string','max:255'],
           
        ];
    }
    public function messages()
    {

        return [
                'latitude.required' => 'The latitude field is required.',
                'latitude.string' => 'The latitude must be a string.',
                'latitude.max' => 'The latitude may not be greater than :max characters.',
                'longitude.required' => 'The longitude field is required.',
                'longitude.string' => 'The longitude must be a string.',
                'longitude.max' => 'The longitude may not be greater than :max characters.',
                
        ];

    }
}
