<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRotationRequest;
use App\Models\Shift;
use App\Models\ShiftRotation;
use App\Services\ShiftRotationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftRotationController extends Controller
{
    public function __construct(protected ShiftRotationService $shiftRotationService)
    {
        //
    }

    public function edit()
    {
        $rotation = ShiftRotation::latest()->first();
        return view('admin.shift-rotations.edit', compact('rotation'));
    }

    public function update(ShiftRotationRequest $request)
    {
        $rotation = ShiftRotation::latest()->first();

        if (!$rotation) {
            ShiftRotation::create([
                'start_date' => $request->start_date,
                'rotation_days' => $request->rotation_days,
            ]);
            return redirect()->back()->with('success', 'Shift rotation created successfully');
        }

        $rotation->update([
            'start_date' => $request->start_date,
            'rotation_days' => $request->rotation_days,
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

        $rotation = ShiftRotation::latest()->first();
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
        // return view('shift_rotation.schedule', compact('schedule'));
    }

}
