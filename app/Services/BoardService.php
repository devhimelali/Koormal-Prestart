<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\CrossCriteria;
use App\Models\DailyShiftEntry;
use App\Models\CelebrateSuccess;
use App\Models\HealthSafetyReview;
use App\Models\ReviewPreviousShift;
use App\Models\HealthSafetyCrossCriteria;
use App\Models\SiteCommunication;

class BoardService
{
    public function saveSupervisorName(Request $request)
    {
        $validated = $request->validate([
            'supervisor_name' => 'required|string|max:255',
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
        ]);

        $dailyShiftEntry = DailyShiftEntry::find($validated['daily_shift_entry_id']);
        $dailyShiftEntry->supervisor_name = $validated['supervisor_name'];
        $dailyShiftEntry->save();
    }

    public function getHealthSafetyReviewForQuestionOne($request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'rotation_id' => 'required|exists:shift_rotations,id',
            'shift_type' => 'required|string|in:day,night'
        ]);

        return HealthSafetyReview::with('dailyShiftEntry')
            ->where('question_number', 'question_one')
            ->whereHas('dailyShiftEntry', function ($query) use ($validated) {
                $query->where('shift_id', $validated['shift_id'])
                    ->where('shift_rotation_id', $validated['rotation_id'])
                    ->where('shift_type', $validated['shift_type']);
            })
            ->get();
    }

    public function getHealthSafetyReviewForQuestionTwo($request)
    {
        return HealthSafetyReview::with('dailyShiftEntry')
            ->where('question_number', 'question_two')
            ->get();
    }

    public function storeHealthSafetyReview(Request $request)
    {
        $validated = $request->validate([
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'question_number' => 'required|in:question_one,question_two',
            'answer' => 'nullable|string',
        ]);

        HealthSafetyReview::updateOrCreate([
            'daily_shift_entry_id' => $validated['daily_shift_entry_id'],
            'question_number' => $validated['question_number']
        ], [
            'answer' => $validated['answer']
        ]);
    }

    public function getCrossCriteria()
    {
        return CrossCriteria::get();
    }

    public function getSafetyCalendarData()
    {
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        return HealthSafetyCrossCriteria::with('crossCriteria')
            ->whereHas('dailyShiftEntry', function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear);
            })
            ->get();
    }

    public function storeHealthSafetyCrossCriteria(Request $request)
    {
        $validated = $request->validate([
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'cell' => 'required|min:1|max:31',
            'criteria_id' => 'required|exists:cross_criterias,id',
        ]);

        //find running month date using cell number
        $date = now()->startOfMonth()->addDays($validated['cell'] - 1)->format('Y-m-d');

        // only allow cross criteria for today
        if ($date != today()->format('Y-m-d')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cross Criteria can only be added for today.'
            ], 400);
        }

        HealthSafetyCrossCriteria::updateOrCreate(
            ['daily_shift_entry_id' => $validated['daily_shift_entry_id']],
            [
                'cross_criteria_id' => $validated['criteria_id'],
                'cell_number' => $validated['cell']
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Cross Criteria created successfully',
            'step' => 3
        ], 201);
    }

    public function getProductiveQuestionOne($request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'rotation_id' => 'required|exists:shift_rotations,id',
            'shift_type' => 'required|string|in:day,night'
        ]);

        return ReviewPreviousShift::with('dailyShiftEntry')
            ->where('question_number', 'question_one')
            ->whereHas('dailyShiftEntry', function ($query) use ($validated) {
                $query->where('shift_id', $validated['shift_id'])
                    ->where('shift_rotation_id', $validated['rotation_id'])
                    ->where('shift_type', $validated['shift_type']);
            })
            ->get();
    }
    public function getProductiveQuestionTwo($request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'rotation_id' => 'required|exists:shift_rotations,id',
            'shift_type' => 'required|string|in:day,night'
        ]);

        return ReviewPreviousShift::with('dailyShiftEntry')
            ->where('question_number', 'question_two')
            ->whereHas('dailyShiftEntry', function ($query) use ($validated) {
                $query->where('shift_id', $validated['shift_id'])
                    ->where('shift_rotation_id', $validated['rotation_id'])
                    ->where('shift_type', $validated['shift_type']);
            })
            ->get();
    }

    public function storeProductiveQuestion($request)
    {
        $validated = $request->validate([
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'question_number' => 'required|in:question_one,question_two',
            'answer' => 'nullable|string',
        ]);

        ReviewPreviousShift::updateOrCreate([
            'daily_shift_entry_id' => $validated['daily_shift_entry_id'],
            'question_number' => $validated['question_number']
        ], [
            'answer' => $validated['answer']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Productive Question saved successfully',
            'step' => $validated['question_number'] == 'question_one' ? 4 : 5
        ]);
    }

    public function getCelebrateSuccesses($request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'rotation_id' => 'required|exists:shift_rotations,id',
            'shift_type' => 'required|string|in:day,night'
        ]);

        return CelebrateSuccess::with('dailyShiftEntry')
            ->whereHas('dailyShiftEntry', function ($query) use ($validated) {
                $query->where('shift_id', $validated['shift_id'])
                    ->where('shift_rotation_id', $validated['rotation_id'])
                    ->where('shift_type', $validated['shift_type']);
            })
            ->get();
    }

    public function storeCelebrateSuccess($request)
    {
        $validated = $request->validate([
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'note' => 'nullable|string',
        ]);

        CelebrateSuccess::updateOrCreate([
            'daily_shift_entry_id' => $validated['daily_shift_entry_id']
        ], [
            'note' => $validated['note']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Celebrate Success saved successfully',
            'step' => 6
        ]);
    }

    public function getSiteCommunications($request)
    {
        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'rotation_id' => 'required|exists:shift_rotations,id',
            'shift_type' => 'required|string|in:day,night'
        ]);

        return SiteCommunication::with('dailyShiftEntry')
            ->whereHas('dailyShiftEntry', function ($query) use ($validated) {
                $query->where('shift_id', $validated['shift_id'])
                    ->where('shift_rotation_id', $validated['rotation_id'])
                    ->where('shift_type', $validated['shift_type']);
            })
            ->get();
    }

    public function storeSiteCommunication($request)
    {
        $validated = $request->validate([
            'daily_shift_entry_id' => 'required|exists:daily_shift_entries,id',
            'note' => 'nullable|string',
        ]);

        SiteCommunication::updateOrCreate([
            'daily_shift_entry_id' => $validated['daily_shift_entry_id']
        ], [
            'note' => $validated['note']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Site Communication saved successfully',
            'step' => 7
        ]);
    }

    public function resetSafetyCalendar($request)
    {
        $currentMonth = now()->format('m');
        $currentYear = now()->format('Y');

        // Reset the safety calendar for the current month
        HealthSafetyCrossCriteria::whereHas('dailyShiftEntry', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear);
        })->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Safety Calendar reset successfully',
            'step' => 3,
        ]);
    }
}
