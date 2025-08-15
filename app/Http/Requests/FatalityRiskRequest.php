<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FatalityRiskRequest extends FormRequest
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
        $imageRule = $this->isMethod('post')
            ? 'required|image|mimes:jpeg,png,jpg,gif,svg'
            : 'nullable|image|mimes:jpeg,png,jpg,gif,svg';

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => $imageRule
        ];
    }
}
