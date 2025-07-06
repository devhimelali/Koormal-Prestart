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

        $healthSafetyReviews = HealthSafetyReview::where('shift_id', $shift->id)
            ->where('rotation_id', $rotation->id)
            ->where('shift_type', $shiftType)
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
        $dateKey = $data['date'];
        $crewName = $data['crew'];

        // Convert start_date to Y-m-d for DB storage
        $startDate = Carbon::createFromFormat('d-m-Y', $data['start_date'])->format('Y-m-d');

        // Extract answers for the specific date key
        $answer_one = $data['question_1'][$dateKey] ?? null;
        $answer_two = $data['question_2'][$dateKey] ?? null;

        // Find shift and rotation IDs
        $shift = Shift::select('id')->where('name', $crewName)->first();
        $rotation = ShiftRotation::select('id')->where('start_date', '<=', $startDate)->orderByDesc('start_date')->first();

        // Return error if shift or rotation not found
        if (!$shift || !$rotation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shift or rotation not found.',
            ], 422);
        }

        // Find or create the health safety review record
        $review = HealthSafetyReview::firstOrCreate(
            [
                'shift_id' => $shift->id,
                'rotation_id' => $rotation->id,
                'shift_type' => $shiftType,
                'start_date' => $startDate,
            ],
            [
                'question_1' => [],
                'question_2' => [],
            ]
        );

        // Merge existing question_1 answers with new one
        $existingQuestion1 = $review->question_1 ?? [];
        if ($answer_one !== null) {
            $existingQuestion1[$dateKey] = $answer_one;
        }

        // Merge existing question_2 answers with new one
        $existingQuestion2 = $review->question_2 ?? [];
        if ($answer_two !== null) {
            $existingQuestion2[$dateKey] = $answer_two;
        }

        // Assign merged answers back to the model
        $review->question_1 = $existingQuestion1;
        $review->question_2 = $existingQuestion2;
        $review->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Health Safety Review saved successfully',
        ], 201);
    }
}
