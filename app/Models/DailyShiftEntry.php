<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyShiftEntry extends Model
{
    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'shift_type',
        'date',
        'supervisor_name',
    ];

    /**
     * An accessor and mutator for the date field that formats the date
     * as 'd-m-Y' for display, and as 'Y-m-d' when saving to the database.
     *
     * @return Attribute
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }


    /**
     * Get the shift associated with this daily shift entry.
     *
     * @return BelongsTo
     */

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Get the shift rotation that this daily shift entry belongs to.
     *
     * @return BelongsTo
     */
    public function rotation(): BelongsTo
    {
        return $this->belongsTo(ShiftRotation::class, 'shift_rotation_id');
    }

    /**
     * Get all health and safety reviews that belong to this daily shift entry.
     *
     * @return HasMany
     */
    public function healthSafetyReviews(): HasMany
    {
        return $this->hasMany(HealthSafetyReview::class);
    }

    /**
     * Get all health and safety cross criteria that belong to this daily shift entry.
     *
     * @return HasMany
     */
    public function healthSafetyCrossCriteria(): HasMany
    {
        return $this->hasMany(HealthSafetyCrossCriteria::class);
    }
}
