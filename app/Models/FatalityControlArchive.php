<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatalityControlArchive extends Model
{
    protected $fillable = [
        'fatality_risk_archive_id',
        'description',
    ];

    public function fatalityRiskArchive()
    {
        return $this->belongsTo(FatalityRiskArchive::class);
    }
}
