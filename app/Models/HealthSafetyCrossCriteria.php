<?php

namespace App\Models;

use App\Models\Concerns\HealthSafetyCrossCriteria\HasAttributes;
use App\Models\Concerns\HealthSafetyCrossCriteria\HasQueryScopes;
use App\Models\Concerns\HealthSafetyCrossCriteria\HasRelations;
use Illuminate\Database\Eloquent\Model;

class HealthSafetyCrossCriteria extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

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
