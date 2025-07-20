<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteCommunication extends Model
{
    protected $fillable = [
        'daily_shift_entry_id',
        'note',
    ];

    /**
     * The daily shift entry that this site communication belongs to.
     *
     * @return BelongsTo
     */
    public function dailyShiftEntry(): BelongsTo
    {
        return $this->belongsTo(DailyShiftEntry::class);
    }
}
