<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Models\DailyShiftEntry;
use Illuminate\Support\Facades\Config;
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
        // Use configured timezone
        $timezone = Config::get('app.timezone', 'Australia/Perth');
        $now = Carbon::now($timezone);
        $date = $now->format('Y-m-d');

        $shiftType = $request->query('shift');
        $crewName = $request->query('crew');

        $startDate = Carbon::createFromFormat('d-m-Y', $request->query('start_date'), $timezone)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d-m-Y', $request->query('end_date'), $timezone)->format('Y-m-d');

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
