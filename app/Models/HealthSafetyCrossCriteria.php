<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthSafetyCrossCriteria extends Model
{
    protected $fillable = [
        'daily_shift_entry_id',
        'cross_criteria_id',
        'cell_number',
    ];

    /**
     * The daily shift entry for the health and safety cross criteria.
     *
     * @return BelongsTo
     */
    public function dailyShiftEntry(): BelongsTo
    {
        return $this->belongsTo(DailyShiftEntry::class);
    }

    /**
     * The cross criteria for the health and safety review.
     *
     * @return BelongsTo
     */
    public function crossCriteria(): BelongsTo
    {
        return $this->belongsTo(CrossCriteria::class);
    }
}
