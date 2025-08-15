<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FatalityControl extends Model
{
    protected $fillable = [
        'fatality_risk_control_id',
        'description',
    ];
}
