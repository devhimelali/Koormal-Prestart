<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use App\Enums\ShiftTypeEnum;
use App\Models\Concerns\ReviewPreviousShift\HasAttributes;
use App\Models\Concerns\ReviewPreviousShift\HasQueryScopes;
use App\Models\Concerns\ReviewPreviousShift\HasRelations;
use Illuminate\Database\Eloquent\Model;

class ReviewPreviousShift extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
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
