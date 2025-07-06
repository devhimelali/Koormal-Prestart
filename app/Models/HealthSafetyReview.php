<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthSafetyReview extends Model
{
    protected $fillable = [
        'start_date',
        'shift_type',
        'shift_id',
        'rotation_id',
        'supervisor_name',
        'question_1',
        'question_2',
    ];

    protected $casts = [
        'question_1' => 'array',
        'question_2' => 'array',
    ];

    /**
     * Get the shift that this health and safety review belongs to
     *
     * @return BelongsTo
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Get the shift rotation that this health and safety review belongs to
     *
     * @return BelongsTo
     */
    public function rotation(): BelongsTo
    {
        return $this->belongsTo(ShiftRotation::class, 'rotation_id');
    }


    /**
     * Accessor and mutator for the start_date attribute.
     * 
     * Formats the start_date from the database format 'Y-m-d' to 'd-m-Y' when retrieving,
     * and from 'd-m-Y' to 'Y-m-d' when storing in the database.
     *
     * @return Attribute
     */
    protected function start_date(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }
}
