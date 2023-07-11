<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceEquipmentRequest extends FormRequest
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
            'task_id' => ['required', 'string', 'max:255'],
            'service_id' => ['required', 'string', 'max:255'],
            'equipment_id' => ['required', 'string', 'max:255'],
            'quantity' => ['string', 'max:255'],
        ];
    }
    public function messages()
    {
        return [
            'task_id.required' => 'The task_id field is required.',
            'task_id.string' => 'The task_id must be a string.',
            'task_id.max' => 'The task_id may not be greater than :max characters.',
            'service_id.required' => 'The service_id field is required.',
            'service_id.string' => 'The service_id must be a string.',
            'service_id.max' => 'The service_id may not be greater than :max characters.',
            'equipment_id.required' => 'The equipment_id field is required.',
            'equipment_id.string' => 'The equipment_id must be a string.',
            'equipment_id.max' => 'The equipment_id may not be greater than :max characters.',
            'quantity.string' => 'The quantity must be a string.',
            'quantity.max' => 'The quantity may not be greater than :max characters.',

        ];
    }
}
