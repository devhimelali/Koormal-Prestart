<?php

namespace App\Models;

use App\Enums\ShiftTypeEnum;
use App\Models\Concerns\FatalRiskToDiscuss\HasAttributes;
use App\Models\Concerns\FatalRiskToDiscuss\HasQueryScopes;
use App\Models\Concerns\FatalRiskToDiscuss\HasRelations;
use Illuminate\Database\Eloquent\Model;

class FatalRiskToDiscuss extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'fatality_risk_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'discuss_note'
    ];

    protected function casts(): array
    {
        return [
            'shift_type' => ShiftTypeEnum::class,
        ];
    }
}
