<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'  =>  'required|string|max:225',
            'body'   =>  'required|string',
            'photo'  =>  'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'tags'   =>  'required|array'
        ];
    }
}
