<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatalRiskToDiscussControlArchive extends Model
{
    protected $fillable = [
        'fatal_risk_to_discuss_archive_id',
        'description',
        'is_manual_entry',
    ];

    public function fatalRiskToDiscussArchive()
    {
        return $this->belongsTo(FatalRiskToDiscussArchive::class);
    }
}
