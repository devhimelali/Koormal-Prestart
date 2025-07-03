<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HealthSafetyReview extends Model
{
    protected $fillable = [
        'date',
        'shift_type',
        'shift_id',
        'supervisor_name',
        'question_1',
        'question_1_audio',
        'question_2',
        'question_2_audio'
    ];
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }
}
