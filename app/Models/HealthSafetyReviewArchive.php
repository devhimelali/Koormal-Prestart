<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class HealthSafetyReviewArchive extends Model
{
    protected $fillable = [
        'crew',
        'shift_rotation',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'question_number',
        'answer',
        'supervisor_name',
        'labour_name'
    ];

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
}
