<?php

namespace App\Http\Requests;

use App\Enums\ShiftTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CelebrateSuccessRequest extends FormRequest
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
            'note' => ['nullable', 'string'],
            'date' => ['nullable', Rule::date()->format('d-m-Y')],
        ];
    }
}
