<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVerification extends FormRequest
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
            'id_number'            => 'required|integer',
            'full_name_card'       => 'required|string|max:50',
            'display_name'         => 'required|string|max:50',
            'user_name'            =>'required|string|max:50',
            'fontside_cardphoto'   => 'required',
            'backside_cardphoto'   =>'required',
            'selfie_photo'         =>'required',
        ];
    }
}
