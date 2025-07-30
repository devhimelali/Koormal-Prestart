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
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'question_number' => 'required|in:question_one,question_two',
            'answer' => 'nullable|string',
        ];

    }

    public function messages(): array
    {
        return [
            'daily_shift_entry_id.required' => 'The daily shift entry ID is required.',
            'daily_shift_entry_id.exists' => 'The daily shift entry ID does not exist.',
            'question_number.required' => 'The question number is required.',
            'question_number.in' => 'The question number is invalid.',
            'answer.string' => 'The answer must be a string.',
        ];
    }
}
