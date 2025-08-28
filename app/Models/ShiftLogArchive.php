<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ShiftLogArchive extends Model
{
    protected $fillable = [
        'position',
        'crew',
        'supervisor_name',
        'labour_name',
        'sh_start_date',
        'sh_end_date',
        'shift_name',
        'wo_number',
        'work_description',
        'duration',
        'asset_no',
        'trades',
        'due_start',
        'status',
        'raised',
        'start_date',
        'priority',
        'job_type',
        'department',
        'material_cost',
        'labor_cost',
        'other_cost',
        'asset_description',
        'supervisor_notes',
        'mark_as_complete',
        'progress',
        'note',
        'labour',
        'is_excel_upload',
        'log_date',
        'requisition',
        'scheduled',
        'critical_work',
    ];
    protected function shStartDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    protected function shEndDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
        );
    }

    public function hazardControlArchives()
    {
        return $this->hasMany(HazardControlArchive::class);
    }

    public function fatalityRisks()
    {
        return $this->belongsToMany(
            FatalityRiskArchive::class,
            'shift_log_fatality_risk_archive',
            'shift_log_archive_id',
            'fatality_risk_archive_id'
        )->withTimestamps();
    }
}
