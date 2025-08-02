<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use App\Enums\ShiftTypeEnum;
use App\Models\Concerns\HealthSafetyReview\HasAttributes;
use App\Models\Concerns\HealthSafetyReview\HasQueryScopes;
use App\Models\Concerns\HealthSafetyReview\HasRelations;
use Illuminate\Database\Eloquent\Model;

class HealthSafetyReview extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'date',
        'shift_type',
        'question_number',
        'answer',
    ];

    protected function casts(): array
    {
        return [
            'shift_type' => ShiftTypeEnum::class,
            'question_number' => QuestionTypeEnum::class
        ];
    }
}
