<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftRotation extends Model
{
    protected $fillable = [
        'start_date',
        'rotation_days'
    ];

    /**
     * Get the active day and night shifts for a given date.
     *
     * @param string $date Format: 'Y-m-d'
     * @return array ['day_shift' => Shift|null, 'night_shift' => Shift|null]
     */
    public function getShiftsForDate(string $date): array
    {
        $startDate = Carbon::parse($this->start_date);
        $currentDate = Carbon::parse($date);

        $daysSinceStart = $startDate->diffInDays($currentDate);
        $cycleLength = 4 * $this->rotation_days;

        $dayInCycle = $daysSinceStart % $cycleLength;
        $rotationIndex = intdiv($dayInCycle, $this->rotation_days);

        $rotations = [
            ['day' => 'A', 'night' => 'C'],
            ['day' => 'B', 'night' => 'D'],
            ['day' => 'C', 'night' => 'A'],
            ['day' => 'D', 'night' => 'B'],
        ];

        if (!isset($rotations[$rotationIndex])) {
            return [
                'day_shift' => null,
                'night_shift' => null,
            ];
        }

        $dayShift = Shift::where('name', $rotations[$rotationIndex]['day'])->first();
        $nightShift = Shift::where('name', $rotations[$rotationIndex]['night'])->first();

        return [
            'day_shift' => $dayShift,
            'night_shift' => $nightShift,
        ];
    }
}
