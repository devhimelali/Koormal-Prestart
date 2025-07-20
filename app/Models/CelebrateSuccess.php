<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CelebrateSuccess extends Model
{
    protected $fillable = [
        'daily_shift_entry_id',
        'note',
    ];

    /**
     * The daily shift entry for the celebrate success.
     *
     * @return BelongsTo
     */
    public function dailyShiftEntry(): BelongsTo
    {
        return $this->belongsTo(DailyShiftEntry::class);
    }
}
