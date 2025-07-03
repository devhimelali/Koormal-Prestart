<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $fillable = [
        'name',
        'linked_shift_id'
    ];

    /**
     * The shift that this one is linked to.
     *
     * This is the opposite of the linkedByShifts relation.
     *
     * @return BelongsTo
     */
    public function linkedShift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'linked_shift_id');
    }

    /**
     * The shifts that link to this one.
     *
     * This is the opposite of the linkedShift relation.
     *
     * @return HasMany
     */
    public function linkedByShifts(): HasMany
    {
        return $this->hasMany(Shift::class, 'linked_shift_id');
    }

    /**
     * The prestart entries that belong to this shift.
     *
     * @return HasMany
     */
    public function prestartEntries(): HasMany
    {
        return $this->hasMany(PrestartEntry::class);
    }
}
