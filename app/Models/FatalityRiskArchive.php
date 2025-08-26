<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatalityRiskArchive extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function fatalityControlArchives()
    {
        return $this->hasMany(FatalityControlArchive::class);
    }

    public function fatalRiskToDiscussArchives()
    {
        return $this->hasMany(FatalRiskToDiscussArchive::class);
    }

    public function hazardControlArchives()
    {
        return $this->hasMany(HazardControlArchive::class);
    }

    public function shiftLogs()
    {
        return $this->belongsToMany(
            ShiftLogArchive::class,
            'table_shift_log_fatality_risk_archive',
            'fatality_risk_archive_id',
            'shift_log_archive_id'
        )->withTimestamps();
    }
}
