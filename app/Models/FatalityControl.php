<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FatalityControl extends Model
{
    protected $fillable = [
        'fatality_risk_id',
        'description',
    ];

    public function fatalityRisk(): BelongsTo
    {
        return $this->belongsTo(FatalityRisk::class);
    }
}
