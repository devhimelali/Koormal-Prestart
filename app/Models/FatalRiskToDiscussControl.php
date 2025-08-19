<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatalRiskToDiscussControl extends Model
{
    protected $fillable = [
        'fatal_risk_to_discuss_id',
        'description',
        'is_manual_entry',
    ];

    public function fatalRiskToDiscuss()
    {
        return $this->belongsTo(FatalRiskToDiscuss::class);
    }
}
