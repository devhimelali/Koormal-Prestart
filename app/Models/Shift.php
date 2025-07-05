<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $fillable = [
        'name',
        'linked_shift_id'
    ];

    /**
     * A shift that is linked to this shift (e.g. a day shift may be linked to a night shift).
     *
     * @return BelongsTo
     */
    public function linkedShift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'linked_shift_id');
    }

    /**
     * Get all shifts that are linked to this shift.
     *
     * @return HasMany
     */

    public function linkedByShifts(): HasMany
    {
        return $this->hasMany(Shift::class, 'linked_shift_id');
    }

    /**
     * Get all health and safety reviews that belong to this shift.
     *
     * @return HasMany
     */
    public function healthSafetyReviews(): HasMany
    {
        return $this->hasMany(HealthSafetyReview::class);
    }
}
