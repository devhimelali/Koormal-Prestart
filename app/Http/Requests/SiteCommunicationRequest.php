<?php

namespace App\Http\Requests;

use App\Enums\ShiftTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiteCommunicationRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            $fileRule = ['required', 'file', 'mimes:pdf'];
        }else{
            $fileRule = ['nullable', 'file', 'mimes:pdf'];
        }
        return [
            'title' => ['required', 'string', 'max:255'],
            'shift_type' => ['required', 'in:day,night,both'],
            'description' => ['required', 'string'],
            'dates' => [
                'required',
                'regex:/^(\d{2}-\d{2}-\d{4})(,\s*\d{2}-\d{2}-\d{4})*$/'
            ],
            'pdf' => $fileRule,
        ];
    }
}
