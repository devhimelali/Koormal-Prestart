<?php

namespace App\Http\Controllers\admin;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Http\Controllers\Controller;
use App\Http\Requests\HealthSafetyReviewRequest;
use App\Models\HealthSafetyReview;

class HealthSafetyReviewController extends Controller
{
    public function index(Request $request)
    {
        $shiftType = $request->shift;
        $crewName = $request->crew;
        $shift = Shift::select('id')->where('name', $crewName)->first();
        $rotation = ShiftRotation::select('id')->where('is_active', true)->first();

        if (!$shift || !$rotation) {
            return back()->with('error', 'Invalid crew or no active rotation.');
        }

        $healthSafetyReviews = HealthSafetyReview::where('shift_id', $shift->id)
            ->where('rotation_id', $rotation->id)
            ->where('shift_type', $shiftType)
            ->get();

        return view('admin.health-safety-reviews.index', [
            'healthSafetyReviews' => $healthSafetyReviews,
            'shift_id' => $shift->id,
            'rotation_id' => $rotation->id,
            'shift_type' => $shiftType
        ]);
    }

    public function store(HealthSafetyReviewRequest $request)
    {
        HealthSafetyReview::updateOrCreate(
            [
                'shift_id' => $request->shift_id,
                'rotation_id' => $request->rotation_id,
                'shift_type' => $request->shift_type,
                'date' => $request->date,
            ],
            [
                'supervisor_name' => $request->supervisor_name,
                'question_1' => $request->question_one,
                'question_2' => $request->question_two,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Health Safety Review created successfully'
        ], 201);
    }
}
