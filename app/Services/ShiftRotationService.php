<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\ShiftRotation;

class ShiftRotationService
{
    public function getDailyShiftSchedule(Carbon $startDate, Carbon $endDate)
    {
        $rotation = ShiftRotation::latest()->first();
        if (!$rotation) {
            return [];
        }

        $days = [];

        // Loop from startDate to endDate inclusive
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $shifts = $rotation->getShiftsForDate($date->toDateString());

            $days[] = [
                'date' => $date->format('d-m-Y'),
                'day_shift' => $shifts['day_shift']->name ?? 'N/A',
                'night_shift' => $shifts['night_shift']->name ?? 'N/A',
            ];
        }

        return $days;
    }

}
