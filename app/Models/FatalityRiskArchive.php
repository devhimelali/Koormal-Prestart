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
}
