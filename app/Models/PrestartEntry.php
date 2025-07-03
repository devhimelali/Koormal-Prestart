<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestartEntry extends Model
{
    protected $fillable = [
        'entry_date',
        'shift_type',
        'shift_id',
        'supervisor_name',
        'safe_action',
        'unsafe_issue',
        'audio_file_path',
    ];

    /**
     * Get the shift associated with the prestart entry.
     *
     * @return BelongsTo
     */

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
