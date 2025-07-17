<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Models\HealthSafetyReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\HealthSafetyReviewRequest;

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

        $healthSafetyReviews = HealthSafetyReview::where('daily_shift_entry_id', $request->daily_shift_entry_id)
            ->first();

        return view('admin.health-safety-reviews.index', [
            'healthSafetyReviews' => $healthSafetyReviews,
            'shift_id' => $shift->id,
            'rotation_id' => $rotation->id,
            'shift_type' => $shiftType
        ]);
    }

    public function store(HealthSafetyReviewRequest $request)
    {
        $data = $request->validated();

        $shiftType = $data['shift'];
        $dateKey = $data['date'] ?? null;
        $crewName = $data['crew'];
        $supervisorName = $data['supervisor_name'] ?? null;

        // Convert start_date to Y-m-d
        $startDate = Carbon::createFromFormat('d-m-Y', $data['start_date'])->format('Y-m-d');

        // Optional question answers
        $answer_one = $data['question_1'][$dateKey] ?? null;
        $answer_two = $data['question_2'][$dateKey] ?? null;

        // Find shift and rotation
        $shift = Shift::select('id')->where('name', $crewName)->first();
        $rotation = ShiftRotation::select('id')->where('start_date', '<=', $startDate)->orderByDesc('start_date')->first();

        if (!$shift || !$rotation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shift or rotation not found.',
            ], 422);
        }

        // Find or create the health safety review
        $review = HealthSafetyReview::firstOrCreate(
            [
                'shift_id' => $shift->id,
                'rotation_id' => $rotation->id,
                'shift_type' => $shiftType,
                'start_date' => $startDate,
            ]
        );

        // Update supervisor name if provided

        $review->supervisor_name = $supervisorName;


        // Merge question_1 if provided
        // if ($answer_one !== null) {
        $existingQuestion1 = $review->question_1 ?? [];
        $existingQuestion1[$dateKey] = $answer_one;
        $review->question_1 = $existingQuestion1;
        // }

        // Merge question_2 if provided
        // if ($answer_two !== null) {
        $existingQuestion2 = $review->question_2 ?? [];
        $existingQuestion2[$dateKey] = $answer_two;
        $review->question_2 = $existingQuestion2;
        // }

        $review->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Health Safety Review saved successfully',
        ], 201);
    }
}
