<?php

namespace App\Models;

use App\Enums\ShiftTypeEnum;
use Illuminate\Database\Eloquent\Model;

class FatalRiskToDiscuss extends Model
{
    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'fatality_risk_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'shift_type' => ShiftTypeEnum::class,
        ];
    }
}
