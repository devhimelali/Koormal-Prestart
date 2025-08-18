<?php

namespace App\Models;

use App\Enums\ShiftTypeEnum;
use App\Models\Concerns\HealthSafetyFocus\HasAttributes;
use App\Models\Concerns\HealthSafetyFocus\HasQueryScopes;
use App\Models\Concerns\HealthSafetyFocus\HasRelations;
use Illuminate\Database\Eloquent\Model;

class HealthSafetyFocus extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'shift_type' => ShiftTypeEnum::class,
        ];
    }
}
