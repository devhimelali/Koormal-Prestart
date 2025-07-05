<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftRotation extends Model
{
    protected $fillable = [
        'start_date',
        'rotation_days',
        'is_active',
    ];

    /**
     * Accessor and mutator for the start date attribute.
     * 
     * Formats the date from the database format 'Y-m-d' to 'd-m-Y' when retrieving,
     * and from 'd-m-Y' to 'Y-m-d' when storing in the database.
     *
     * @return Attribute
     */

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }

    /**
     * Get all health and safety reviews that belong to this shift rotation.
     *
     * @return HasMany
     */
    public function healthSafetyReviews(): HasMany
    {
        return $this->hasMany(HealthSafetyReview::class);
    }

    /**
     * Get the shift blocks for this shift rotation.
     *
     * @return Collection
     */
    public function getShiftBlocks(?Carbon $filterStart = null, ?Carbon $filterEnd = null): Collection
    {
        $startDate = Carbon::parse($this->start_date);
        $rotationDays = $this->rotation_days;

        if (!$rotationDays || $rotationDays <= 0) {
            return collect(); // Invalid config
        }

        // Load shifts and map by name
        $shiftNames = ['A', 'B', 'C', 'D'];
        $shiftsByName = Shift::whereIn('name', $shiftNames)->get()->keyBy('name');
        $getShift = fn($name) => $shiftsByName->get($name);

        $rotationOrder = [
            ['day_shift' => $getShift('A'), 'night_shift' => $getShift('C')],
            ['day_shift' => $getShift('B'), 'night_shift' => $getShift('D')],
            ['day_shift' => $getShift('C'), 'night_shift' => $getShift('A')],
            ['day_shift' => $getShift('D'), 'night_shift' => $getShift('B')],
        ];

        $blocks = collect();
        $i = 0;

        while (true) {
            $blockStart = $startDate->copy()->addDays($i * $rotationDays);
            $blockEnd = $blockStart->copy()->addDays($rotationDays - 1);

            // 1. Stop if filterEnd is set and this block is completely after it
            if ($filterEnd && $blockStart->gt($filterEnd)) {
                break;
            }

            // 2. Skip this block if it ends before the filterStart
            if ($filterStart && $blockEnd->lt($filterStart)) {
                $i++;
                continue;
            }

            // 3. Add block
            $index = $i % 4;
            $blocks->push([
                'start_date' => $blockStart->format('d-m-Y'),
                'end_date' => $blockEnd->format('d-m-Y'),
                'day_shift' => $rotationOrder[$index]['day_shift']?->name ?? 'N/A',
                'night_shift' => $rotationOrder[$index]['night_shift']?->name ?? 'N/A',
            ]);

            $i++;

            // 4. Stop at 10 blocks if no filters were applied
            if (!$filterStart && !$filterEnd && $i >= 10) {
                break;
            }
        }

        return $blocks;
    }


}
