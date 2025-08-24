<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FatalRiskToDiscussArchive extends Model
{
    protected $fillable = [
        'crew',
        'shift_rotation',
        'fatality_risk_archive_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'discuss_note'
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
