<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftRotation extends Model
{
    protected $fillable = [
        'week_index',
        'day_shift_id',
        'night_shift_id',
    ];

    /**
     * Get the day shift of the rotation.
     *
     * @return BelongsTo
     */
    public function dayShift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'day_shift_id');
    }


    /**
     * Get the night shift of the rotation.
     *
     * @return BelongsTo
     */

    public function nightShift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'night_shift_id');
    }
}
