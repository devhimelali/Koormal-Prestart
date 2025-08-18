<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImproveOurPerformance extends Model
{
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
