<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FatalityRisk extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * Get the shift log that this fatality risk control belongs to.
     *
     * @return BelongsTo
     */
    public function shiftLog(): BelongsTo
    {
        return $this->belongsTo(ShiftLog::class, 'shift_log_id', 'id');
    }

    public function fatalityControls()
    {
        return $this->hasMany(FatalityControl::class);
    }

    public function hazardControls()
    {
        return $this->hasMany(HazardControl::class);
    }
}
