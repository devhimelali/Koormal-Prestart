<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewPreviousShift extends Model
{
    protected $fillable = [
        'daily_shift_entry_id',
        'question_number',
        'answer',
    ];

    /**
     * Get the daily shift entry that this review belongs to.
     *
     * @return BelongsTo
     */
    public function dailyShiftEntry(): BelongsTo
    {
        return $this->belongsTo(DailyShiftEntry::class);
    }
}
