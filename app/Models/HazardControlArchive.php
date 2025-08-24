<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardControlArchive extends Model
{
    protected $fillable = [
        'shift_log_archive_id',
        'fatality_risk_archive_id',
        'description',
        'is_manual_entry',
    ];
}
