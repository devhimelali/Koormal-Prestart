<?php

namespace App\Models\Concerns\FatalRiskToDiscuss;

use App\Models\FatalityRisk;
use App\Models\Shift;
use App\Models\ShiftRotation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelations
{
    /**
     * Get the shift that this Fatality to discuss belongs to.
     *
     * @return BelongsTo
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }


    /**
     * Get the shift rotation that this Fatality to discuss belongs to.
     *
     * @return BelongsTo
     */
    public function shiftRotation(): BelongsTo
    {
        return $this->belongsTo(ShiftRotation::class);
    }

    /**
     * Get the fatality risk that this Fatality to discuss belongs to.
     *
     * @return BelongsTo
     */
    public function fatalityRisk(): BelongsTo
    {
        return $this->belongsTo(FatalityRisk::class);
    }
}
