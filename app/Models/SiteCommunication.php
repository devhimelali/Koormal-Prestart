<?php

namespace App\Models;

use App\Enums\ShiftTypeEnum;
use App\Models\Concerns\SiteCommunication\HasAttributes;
use App\Models\Concerns\SiteCommunication\HasQueryScopes;
use App\Models\Concerns\SiteCommunication\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteCommunication extends Model
{
    use HasAttributes, HasQueryScopes, HasRelations;

    protected $fillable = [
        'shift_id',
        'shift_rotation_id',
        'start_date',
        'end_date',
        'shift_type',
        'date',
        'note',
    ];


    protected function casts(): array
    {
        return [
            'shift_type' => ShiftTypeEnum::class,
        ];
    }
}
