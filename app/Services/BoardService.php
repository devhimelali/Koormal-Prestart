<?php

namespace App\Services;

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
}
