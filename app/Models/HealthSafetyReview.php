<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthSafetyReview extends Model
{
    protected $fillable = [
        'daily_shift_entry_id',
        'question_number',
        'answer',
    ];

    public function dailyShiftEntry(): BelongsTo
    {
        return $this->belongsTo(DailyShiftEntry::class);
    }
}
