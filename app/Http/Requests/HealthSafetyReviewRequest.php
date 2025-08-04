<?php

namespace App\Http\Requests;

use App\Enums\QuestionTypeEnum;
use App\Enums\ShiftTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'shift_id' => ['required', Rule::exists('shifts', 'id')],
            'shift_rotation_id' => ['required', Rule::exists('shift_rotations', 'id')],
            'start_date' => ['required', Rule::date()->format('d-m-Y')],
            'end_date' => ['required', Rule::date()->format('d-m-Y')->afterOrEqual('start_date')],
            'shift_type' => ['required', Rule::enum(ShiftTypeEnum::class)],
            'question_number' => ['required', Rule::enum(QuestionTypeEnum::class)],
            'answer' => ['nullable', 'string'],
            'date' => ['nullable', Rule::date()->format('d-m-Y')],
        ];
    }

    public function messages(): array
    {
        return [
            'shift_id.required' => 'Shift ID is required.',
            'shift_id.exists' => 'The selected shift does not exist.',
            'shift_rotation_id.required' => 'Shift rotation ID is required.',
            'shift_rotation_id.exists' => 'The selected shift rotation does not exist.',
            'start_date.required' => 'Start date is required.',
            'start_date.format' => 'Start date must be a valid date in the format d-m-Y.',
            'end_date.required' => 'End date is required.',
            'end_date.format' => 'End date must be a valid date in the format d-m-Y.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'shift_type.required' => 'Shift type is required.',
            'question_number.required' => 'Question number is required.',
            'answer.string' => 'Answer must be a string.',
            'date.format' => 'Date must be a valid date in the format d-m-Y.',
        ];
    }
}
