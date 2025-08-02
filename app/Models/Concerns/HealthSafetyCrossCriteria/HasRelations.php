<?php

namespace App\Models\Concerns\HealthSafetyCrossCriteria;

use App\Models\CrossCriteria;
use App\Models\Shift;
use App\Models\ShiftRotation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelations
{
    /**
     * The cross-criteria for the health and safety review.
     *
     * @return BelongsTo
     */
    public function crossCriteria(): BelongsTo
    {
        return $this->belongsTo(CrossCriteria::class);
    }

    /**
     * Get the shift that this health and safety review belongs to.
     *
     * @return BelongsTo
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }


    /**
     * Get the shift rotation that this health and safety review belongs to.
     *
     * @return BelongsTo
     */
    public function shiftRotation(): BelongsTo
    {
        return $this->belongsTo(ShiftRotation::class);
    }
}
