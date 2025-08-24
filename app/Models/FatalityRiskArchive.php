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
}
