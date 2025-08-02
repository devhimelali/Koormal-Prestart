<?php

namespace App\Models;

use App\Models\Concerns\HealthSafetyCrossCriteria\HasAttributes;
use App\Models\Concerns\HealthSafetyCrossCriteria\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthSafetyCrossCriteria extends Model
{
    use HasAttributes, HasRelations;

    protected $fillable = [
        'cross_criteria_id',
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'cell_number',
    ];
}
