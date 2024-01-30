<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password'     => 'required',
            'new_password'         => 'required|min:8',
            'confirm_password'     => 'required|same:new_password',
        ];
    }

    public function messages(){
        return [
            'current_password.required'   => 'Please enter your current password',
            'new_password.required'       => 'Please enter your new password',
            'confirm_password.required'   => 'please confirm your new password',
        ];

    }
}
