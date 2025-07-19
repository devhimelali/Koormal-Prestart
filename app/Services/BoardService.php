<?php

namespace App\Services;

use App\Models\CrossCriteria;
use App\Models\HealthSafetyCrossCriteria;
use Illuminate\Http\Request;
use App\Models\DailyShiftEntry;
use App\Models\HealthSafetyReview;

class BoardService
{
    public function saveSupervisorName(Request $request)
    {
        $dailyShiftEntry = DailyShiftEntry::find($request->daily_shift_entry_id);
        $dailyShiftEntry->supervisor_name = $request->supervisor_name;
        $dailyShiftEntry->save();
    }

    public function getHealthSafetyReviewForQuestionOne($dailyShiftEntryId)
    {
        return HealthSafetyReview::with('dailyShiftEntry')
            ->where('question_number', 'question_one')
            ->where('daily_shift_entry_id', $dailyShiftEntryId)
            ->get();
    }
    public function getHealthSafetyReviewForQuestionTwo($dailyShiftEntryId)
    {
        return HealthSafetyReview::with('dailyShiftEntry')
            ->where('question_number', 'question_two')
            ->where('daily_shift_entry_id', $dailyShiftEntryId)
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
        $startDate = now()->startOfMonth()->format('d-m-Y'); // example 01-07-2025
        $endDate = now()->endOfMonth()->format('d-m-Y'); // example 31-07-2025

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
}
