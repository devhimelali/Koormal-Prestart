<?php

namespace App\Services;

use App\DTOs\HealthSafetyReviewCrossCriteriaDto;
use App\DTOs\HealthSafetyReviewDto;
use App\DTOs\ReviewOfPreviousShiftDto;
use App\Http\Requests\HealthSafetyReviewRequest;
use App\Models\LabourShift;
use App\Models\ShiftLog;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\CrossCriteria;
use App\Models\DailyShiftEntry;
use App\Models\CelebrateSuccess;
use App\Models\HealthSafetyReview;
use App\Models\ReviewPreviousShift;
use App\Models\HealthSafetyCrossCriteria;
use App\Models\SiteCommunication;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
        return HealthSafetyReview::questionOne($request)
            ->get();
    }

    public function getHealthSafetyReviewForQuestionTwo($request)
    {
        return HealthSafetyReview::questionTwo($request)
            ->get();
    }

    public function storeHealthSafetyReview(HealthSafetyReviewDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        HealthSafetyReview::updateOrCreate([
            'shift_id' => $dto->shift_id,
            'shift_rotation_id' => $dto->shift_rotation_id,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'shift_type' => $dto->shift_type,
            'question_number' => $dto->question_number,
        ], [
            'answer' => $dto->answer,
            'date' => $shiftDate,
        ]);
    }

    public function getCrossCriteria()
    {
        return CrossCriteria::get();
    }

    public function getSafetyCalendarData($request)
    {

        return HealthSafetyCrossCriteria::filterSafetyCalendar($request)
            ->get();
    }

    public function storeHealthSafetyCrossCriteria(HealthSafetyReviewCrossCriteriaDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        $date = now(Config::get('app.timezone', 'Australia/Perth'))
            ->startOfMonth()
            ->addDays($dto->cell_number - 1)
            ->format('Y-m-d');

        // only allow cross-criteria for today
        if ($date != today()->format('Y-m-d')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cross Criteria can only be added for today.'
            ], 400);
        }

        HealthSafetyCrossCriteria::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
            ],
            [
                'date' => $shiftDate,
                'cross_criteria_id' => $dto->cross_criteria_id,
                'cell_number' => $dto->cell_number,
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
        return ReviewPreviousShift::filterPreviousShiftsQuestionOne($request)
            ->get();
    }

    public function getProductiveQuestionTwo($request)
    {
        return ReviewPreviousShift::filterPreviousShiftsQuestionTwo($request)
            ->get();
    }

    public function storeProductiveQuestion(ReviewOfPreviousShiftDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        ReviewPreviousShift::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'question_number' => $dto->question_number,
            ],
            [
                'date' => $shiftDate,
                'answer' => $dto->answer,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Productive Question saved successfully',
            'step' => $dto->question_number == 'question_one' ? 4 : 5
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

    public function getSupervisorName($shift, $date)
    {
        return Supervisor::where('date', $date)->where('shift', $shift)->first();
    }

    public function getLaborName($shift, $date)
    {
        return LabourShift::where('date', $date)->where('shift', $shift)->first();
    }

    public function getShiftLog($shift, $date)
    {
        return ShiftLog::where('log_date', $date)->where('shift_name', $shift)->get();
    }

    public function assignFatalityRiskControl($request)
    {
        $validated = $request->validate([
            'fatality_risk_control' => 'required|array|min:1',
            'fatality_risk_control.*' => 'integer|exists:fatality_risk_controls,id',
            'type' => 'required|string|in:add,edit',
            'shift_log_id' => 'required',
        ]);

        if ($validated['type'] == 'add') {
            $this->storeFatalityRiskControlToShiftLog($validated);
        } elseif ($validated['type'] == 'edit') {
            DB::table('shift_log_fatality_risk_control')->where('shift_log_id', $validated['shift_log_id'])->delete();
            $this->storeFatalityRiskControlToShiftLog($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control assigned successfully',
            'step' => 8
        ]);
    }

    private function storeFatalityRiskControlToShiftLog($validated)
    {
        foreach ($validated['fatality_risk_control'] as $fatalityRiskControlId) {
            DB::table('shift_log_fatality_risk_control')->insert([
                'shift_log_id' => $validated['shift_log_id'],
                'fatality_risk_control_id' => $fatalityRiskControlId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function getShiftDate()
    {
        $timezone = Config::get('app.timezone', 'Australia/Perth');
        $now = Carbon::now($timezone);
        return $now->copy()->format('Y-m-d');
    }
}
