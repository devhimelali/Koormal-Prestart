<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardControl extends Model
{
    protected $fillable = [
        'shift_log_id',
        'fatality_risk_id',
        'description',
        'is_manual_entry'
    ];

    public function fatalityRisk()
    {
        return $this->belongsTo(FatalityRisk::class);
    }
}
