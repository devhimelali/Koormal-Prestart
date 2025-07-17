<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DailyShiftEntry;
use App\Services\BoardService;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function __construct(public BoardService $boardService)
    {
        //code here
    }
    public function index(Request $request)
    {
        return view('admin.boards.index', [
            'dailyShiftEntry' => DailyShiftEntry::findOrFail($request->daily_shift_entry_id),
            'shiftType' => $request->shift,
            'crewName' => $request->crew,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date
        ]);
    }

    public function updateSupervisorName(Request $request)
    {
        $this->boardService->saveSupervisorName($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Supervisor name updated successfully',
        ]);
    }

    public function show(Request $request)
    {
        $step = $request->step;
        $dailyShiftEntryId = $request->daily_shift_entry_id;
        if ($step == 1) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReview($dailyShiftEntryId);

            return view('admin.boards.health-safety-review-question-one', [
                'healthSafetyReview' => $healthSafetyReview
            ]);
        } elseif ($step == 2) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReview($dailyShiftEntryId);

            return view('admin.boards.health-safety-review-question-two', [
                'healthSafetyReview' => $healthSafetyReview
            ]);
        } elseif ($step == 3) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReview($dailyShiftEntryId);

            return view('admin.boards.health-safety-cross-criteria', [
                'healthSafetyReview' => $healthSafetyReview
            ]);
        }
    }
}


