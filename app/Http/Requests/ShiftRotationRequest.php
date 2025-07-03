<?php

namespace App\Http\Requests;

use App\Models\Shift;
use Illuminate\Foundation\Http\FormRequest;

class ShiftRotationRequest extends FormRequest
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
            'start_date' => 'required|date_format:d-m-Y',
            'rotation_days' => 'required|integer|min:1',
        ];
    }

    /**
     * Custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'The start date field is required.',
            'start_date.date_format' => 'The start date field must be a valid date in the format d-m-Y.',
            'rotation_days.required' => 'The rotation days field is required.',
            'rotation_days.integer' => 'The rotation days field must be an integer.',
            'rotation_days.min' => 'The rotation days field must be at least 1.',
        ];
    }
}
