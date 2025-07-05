<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthSafetyReviewRequest extends FormRequest
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
            'shift_id' => 'required|integer|exists:shifts,id',
            'rotation_id' => 'required|integer|exists:shift_rotations,id',
            'shift_type' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
            'supervisor_name' => 'required|string|max:255',
            'question_one' => 'nullable|string',
            'question_two' => 'nullable|string',
        ];

    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'You cannot select a future date.',
            'shift_id.required' => 'Shift is required.',
            'rotation_id.required' => 'Rotation is required.',
        ];
    }
}
