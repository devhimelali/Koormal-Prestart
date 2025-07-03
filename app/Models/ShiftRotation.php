<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftRotation extends Model
{
    protected $fillable = [
        'start_date',
        'rotation_days'
    ];

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn($value) => Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d'),
        );
    }

    /**
     * Get the active day and night shifts for a given date.
     *
     * @param string $date Format: 'Y-m-d'
     * @return array ['day_shift' => Shift|null, 'night_shift' => Shift|null]
     */
    // public function getShiftsForDate(string $date): array
    // {
    //     $startDate = Carbon::parse($this->start_date);
    //     $currentDate = Carbon::parse($date);

    //     $daysSinceStart = $startDate->diffInDays($currentDate);
    //     $cycleLength = 4 * $this->rotation_days;

    //     $dayInCycle = $daysSinceStart % $cycleLength;
    //     $rotationIndex = intdiv($dayInCycle, $this->rotation_days);

    //     // ✅ Build dynamic rotations based on linked shifts
    //     $baseShifts = Shift::with('linkedShift')->get();

    //     // Build pairs in the order A/B/C/D based on ID or name
    //     $rotations = [];

    //     foreach ($baseShifts as $shift) {
    //         if (
    //             $shift->linkedShift &&
    //             // avoid duplicate pairs like A-C and C-A
    //             !collect($rotations)->contains(
    //                 fn($r) =>
    //                 ($r['day'] === $shift->linkedShift->name && $r['night'] === $shift->name)
    //             )
    //         ) {
    //             $rotations[] = [
    //                 'day' => $shift->name,
    //                 'night' => $shift->linkedShift->name,
    //             ];
    //         }
    //     }

    //     if (!isset($rotations[$rotationIndex])) {
    //         return ['day_shift' => null, 'night_shift' => null];
    //     }

    //     $dayShift = Shift::where('name', $rotations[$rotationIndex]['day'])->first();
    //     $nightShift = Shift::where('name', $rotations[$rotationIndex]['night'])->first();

    //     return [
    //         'day_shift' => $dayShift,
    //         'night_shift' => $nightShift,
    //     ];
    // }
    public function getShiftsForDate(string $date)
    {
        $date = Carbon::parse($date);
        $startDate = Carbon::parse($this->start_date);
        $rotationDays = $this->rotation_days;

        // Validate essential data
        if (!$startDate || !$rotationDays || $rotationDays <= 0) {
            return ['day_shift' => null, 'night_shift' => null];
        }

        // Total length of full cycle (e.g. 7 days × 4 shifts = 28)
        $cycleLength = $rotationDays * 4;

        // Days difference from start date to given date
        $daysSinceStart = $startDate->diffInDays($date);

        // Find day position in cycle (0 to cycleLength - 1)
        $dayInCycle = $daysSinceStart % $cycleLength;

        // Determine block index (which 7-day shift block)
        $blockIndex = intdiv($dayInCycle, $rotationDays);

        // Fetch all shifts at once, cache by name for quick lookup
        $shiftNames = ['A', 'B', 'C', 'D'];
        $shiftsByName = Shift::whereIn('name', $shiftNames)
            ->get()
            ->keyBy('name');

        // Define rotation pattern for each block index
        $rotationOrder = [
            ['day_shift' => $shiftsByName->get('A'), 'night_shift' => $shiftsByName->get('C')],
            ['day_shift' => $shiftsByName->get('B'), 'night_shift' => $shiftsByName->get('D')],
            ['day_shift' => $shiftsByName->get('C'), 'night_shift' => $shiftsByName->get('A')],
            ['day_shift' => $shiftsByName->get('D'), 'night_shift' => $shiftsByName->get('B')],
        ];

        return $rotationOrder[$blockIndex] ?? ['day_shift' => null, 'night_shift' => null];
    }
}
