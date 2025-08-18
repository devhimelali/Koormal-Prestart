<?php

namespace App\Models;

use App\Models\Concerns\ImproveOurPerformance\HasAttributes;
use App\Models\Concerns\ImproveOurPerformance\HasQueryScopes;
use App\Models\Concerns\ImproveOurPerformance\HasRelations;
use Illuminate\Database\Eloquent\Model;

class ImproveOurPerformance extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'issues',
        'who',
    ];
}
