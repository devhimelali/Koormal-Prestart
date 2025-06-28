<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RotationSetting extends Model
{
    protected $fillable = [
        'start_date',
        'rotation_days',
    ];

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }
}
