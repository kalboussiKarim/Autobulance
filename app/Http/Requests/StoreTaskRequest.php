<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'autobulance_id' => ['required', 'string', 'max:255'],
            'request_id' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'required', 'in:done,to do,canceled,in progress'],
        ];
    }
    public function messages()
    {
        return [
            'autobulance_id.required' => 'The autobulance field is required.',
            'autobulance_id.string' => 'The autobulance field must be a string.',
            'autobulance_id.max' => 'The autobulance field is too long.',
            'request_id.required' => 'The request field is required.',
            'request_id.string' => 'The request must be a string.',
            'request_id.max' => 'The request field is too long.',
            'state.max' => 'The state field is too long.',
            'state.required' => 'The state field is required.',
            'state.in' => 'The selected state is invalid.',

        ];
    }
}
