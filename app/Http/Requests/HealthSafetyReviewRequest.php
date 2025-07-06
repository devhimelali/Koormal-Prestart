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
            'start_date' => 'required|date_format:d-m-Y',
            'crew' => 'required|string',
            'shift' => 'required|string|in:day,night',
            'date' => 'required|date_format:d-m-Y',
            'question_1' => 'nullable|array',
            'question_1.*' => 'nullable|string',
            'question_2' => 'nullable|array',
            'question_2.*' => 'nullable|string',
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
