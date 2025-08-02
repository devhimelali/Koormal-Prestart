<?php

namespace App\Http\Requests;

use App\Enums\ShiftTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowBoardRequest extends FormRequest
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
            'step' => ['required', Rule::numeric()->min(1)->max(8)],
            'shift_id' => ['required', Rule::exists('shifts', 'id')],
            'shift_type' => ['required', Rule::enum(ShiftTypeEnum::class)],
            'start_date' => ['required', Rule::date()->format('d-m-Y')],
            'end_date' => ['required', Rule::date()->format('d-m-Y')->afterOrEqual('start_date')],
        ];
    }

    public function messages(): array
    {
        return [
            'step.required' => 'Step is required.',
            'step.numeric' => 'Step must be a number.',
            'step.min' => 'Step must be at least 1.',
            'step.max' => 'Step must be at most 8.',
            'shift_id.required' => 'Shift ID is required.',
            'shift_id.exists' => 'The selected shift does not exist.',
            'shift_type.required' => 'Shift type is required.',
            'start_date.required' => 'Start date is required.',
            'start_date.format' => 'Start date must be a valid date in the format d-m-Y.',
            'end_date.required' => 'End date is required.',
            'end_date.format' => 'End date must be a valid date in the format d-m-Y.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
        ];
    }
}
