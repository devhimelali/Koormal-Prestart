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
        $id = $this->route('shift_rotation');

        return [
            'week_index' => 'required|integer|min:0|max:3|unique:shift_rotations,week_index,' . $id,
            'day_shift_id' => 'required|exists:shifts,id|different:night_shift_id',
            'night_shift_id' => 'required|exists:shifts,id|different:day_shift_id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dayShift = Shift::find($this->day_shift_id);
            if ($dayShift && $dayShift->linked_shift_id != $this->night_shift_id) {
                $validator->errors()->add('night_shift_id', 'Selected night shift does not match the linked shift of the selected day shift.');
            }
        });
    }
}
