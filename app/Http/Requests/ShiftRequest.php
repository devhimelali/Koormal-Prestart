<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
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
        $shiftId = $this->route('shift')?->id ?? null;

        return [
            'name' => [
                'required',
                Rule::unique('shifts', 'name')->ignore($shiftId),
            ],
            'linked_shift_id' => [
                'nullable',
                'exists:shifts,id',
                'different:id', // optional: can't be linked to self
                function ($attribute, $value, $fail) use ($shiftId) {
                    if ($value == $shiftId) {
                        $fail('You cannot link a shift to itself. Please choose a different shift.');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a name for the shift.',
            'name.unique' => 'This shift name is already in use. Please choose a different name.',
            'linked_shift_id.exists' => 'The selected linked shift does not exist.',
            'linked_shift_id.different' => 'You cannot link the shift to itself. Please choose a different shift.',
        ];
    }
}
