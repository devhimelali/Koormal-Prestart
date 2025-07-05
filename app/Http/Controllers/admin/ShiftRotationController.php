<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Http\Controllers\Controller;
use App\Services\ShiftRotationService;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ShiftRotationRequest;

class ShiftRotationController extends Controller
{
    public function __construct(protected ShiftRotationService $shiftRotationService)
    {
        //
    }

    public function edit()
    {
        $rotation = ShiftRotation::where('is_active', true)->first();
        return view('admin.shift-rotations.edit', compact('rotation'));
    }

    public function update(ShiftRotationRequest $request)
    {
        // deactivate existing
        ShiftRotation::where('is_active', true)->update(['is_active' => false]);

        // create new active rotation
        ShiftRotation::create([
            'start_date' => $request->start_date,
            'rotation_days' => $request->rotation_days,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Shift rotation updated successfully');
    }

    public function checkForm()
    {
        return view('rotation.check');
    }

    public function checkResult(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:day,night',
        ]);

        $rotation = ShiftRotation::where('is_active', true)->first();
        $shifts = $rotation->getShiftsForDate($request->date);

        $selected = $request->type === 'day' ? $shifts['day_shift'] : $shifts['night_shift'];

        return view('rotation.check', [
            'date' => $request->date,
            'type' => $request->type,
            'result' => $selected,
        ]);
    }

    public function showNextMonthSchedule()
    {
        $startDate = now()->startOfDay();
        $endDate = now()->addMonth()->endOfDay();

        $dailySchedule = $this->shiftRotationService->getDailyShiftSchedule($startDate, $endDate);
        return view('shift_rotation.schedule', compact('dailySchedule'));
    }

    public function applyDataRangeFilter(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $dailySchedule = $this->shiftRotationService->getDailyShiftSchedule($startDate, $endDate);

        return response()->json($dailySchedule);
    }

}
