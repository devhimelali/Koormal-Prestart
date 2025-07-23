<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Models\DailyShiftEntry;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class DailyShiftEntryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $shiftType = $request->query('shift');
        $crewName = $request->query('crew');
        $date = today()->format('Y-m-d');
        $startDate = Carbon::createFromFormat('d-m-Y', $request->query('start_date'))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d-m-Y', $request->query('end_date'))->format('Y-m-d');

        $shift = Shift::where('name', $crewName)->value('id');
        $rotation = ShiftRotation::where('is_active', true)->value('id');

        if (!$shift || !$rotation) {
            return back()->with('error', 'Invalid crew or no active rotation.');
        }

        if ($date >= $startDate && $date <= $endDate) {
            $dailyShiftEntry = DailyShiftEntry::firstOrCreate([
                'shift_id' => $shift,
                'shift_rotation_id' => $rotation,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'shift_type' => $shiftType,
                'date' => $date,
            ]);

            $request->merge(['daily_shift_entry_id' => $dailyShiftEntry->id]);
        } else {
            return back()->with('error', 'Start date must be before end date.');
        }

        return $next($request);
    }
}
