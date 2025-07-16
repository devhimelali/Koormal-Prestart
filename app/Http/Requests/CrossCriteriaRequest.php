<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrossCriteriaRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
            'color' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'color.required' => 'Color is required.',
        ];
    }
}
