<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ShiftLog extends Model
{
    protected $connection = 'mysql1';
    protected $table = 'shift_logs';

    public function fatalityRiskControls(): HasMany
    {
        return $this->hasMany(FatalityRisk::class, 'shift_log_id', 'id');
    }
    public function getFatalityRiskControlsAttribute()
    {
        return DB::connection('mysql')
            ->table('shift_log_fatality_risk_control as pivot')
            ->join('fatality_risk_controls as frc', 'pivot.fatality_risk_control_id', '=', 'frc.id')
            ->where('pivot.shift_log_id', $this->id)
            ->select('frc.*') // or 'frc.field1', 'frc.field2' if you want specific columns
            ->get();
    }
}
