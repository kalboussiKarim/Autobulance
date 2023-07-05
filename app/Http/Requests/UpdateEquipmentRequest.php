<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
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
            'name' => ['string', 'max:255', 'unique:equipment'],
            'stock' => ['integer'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The name of the equipment must be a string.',
            'name.max' => 'The name field must not exceed :max characters.',
            'name.unique' => 'This equipment already exists.',
            'stock.integer' => 'The stock field must be a valid integer.',
        ];
    }
}
