<?php

namespace App\Services;

use App\DTOs\CelebrateSuccessDto;
use App\DTOs\FatalRiskToDiscussDto;
use App\DTOs\HealthSafetyFocusDto;
use App\DTOs\HealthSafetyReviewCrossCriteriaDto;
use App\DTOs\HealthSafetyReviewDto;
use App\DTOs\ImproveOurPerformanceDto;
use App\DTOs\ReviewOfPreviousShiftDto;
use App\DTOs\SiteCommunicationDto;
use App\Models\FatalityControl;
use App\Models\FatalityRisk;
use App\Models\FatalRiskToDiscuss;
use App\Models\FatalRiskToDiscussControl;
use App\Models\HazardControl;
use App\Models\HealthSafetyFocus;
use App\Models\ImproveOurPerformance;
use App\Models\LabourShift;
use App\Models\ShiftLog;
use App\Models\Supervisor;
use Carbon\Carbon;
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
            'date' => $dto->date ? $dto->date : $shiftDate,
        ],
            [
                'answer' => $dto->answer,
            ]
        );
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
                'message' => 'You can only add safety colour assessment to today’s date.'
            ], 400);
        }

        HealthSafetyCrossCriteria::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $shiftDate,
            ],
            [
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
                'date' => $dto->date ? $dto->date : $shiftDate,
            ],
            [
                'answer' => $dto->answer,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Productive Question saved successfully',
            'step' => $dto->question_number->value == 'question_one' ? 4 : 5
        ]);
    }

    public function getCelebrateSuccesses($request)
    {
        return CelebrateSuccess::filterSuccessNote($request)
            ->get();
    }

    public function storeCelebrateSuccess(CelebrateSuccessDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        CelebrateSuccess::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $dto->date ? $dto->date : $shiftDate,
            ],
            [
                'note' => $dto->note,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Celebrate Success saved successfully',
            'step' => 6
        ]);
    }

    public function getSiteCommunications($request)
    {
        return SiteCommunication::filterCommunication($request)
            ->get();
    }

    public function storeSiteCommunication(SiteCommunicationDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        SiteCommunication::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $dto->date ? $dto->date : $shiftDate,
            ],
            [
                'note' => $dto->note
            ]
        );

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
            'fatality_risk_control.*' => 'integer|exists:fatality_risks,id',
            'type' => 'required|string|in:add,edit',
            'shift_log_id' => 'required',
        ]);

        if ($validated['type'] == 'add') {
            $this->storeFatalityRiskControlToShiftLog($validated);
        } elseif ($validated['type'] == 'edit') {
            DB::table('shift_log_fatality_risk')->where('shift_log_id', $validated['shift_log_id'])->delete();
            $this->storeFatalityRiskControlToShiftLog($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control assigned successfully',
            'step' => 8
        ]);
    }

    public function getHazardControlsByFatalityRisk($fatalityRiskId, $shiftLogId)
    {
        return HazardControl::where('fatality_risk_id', $fatalityRiskId)
            ->where('shift_log_id', $shiftLogId)
            ->get();
    }

    public function getFatalityControlsByFatalityRisk($fatalityRiskId)
    {
        return FatalityControl::where('fatality_risk_id', $fatalityRiskId)
            ->get();
    }

    public function getImprovePerformances($request)
    {
        return ImproveOurPerformance::filterImproveOurPerformance($request)
            ->get();
    }

    public function storeImprovePerformance(ImproveOurPerformanceDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        ImproveOurPerformance::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $dto->date ? $dto->date : $shiftDate,
            ],
            [
                'issues' => $dto->issues,
                'who' => $dto->who,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Improve Performance saved successfully',
            'step' => 9
        ]);
    }

    public function getSafetyFocuses($request)
    {
        return HealthSafetyFocus::filterHealthSafetyFocus($request)
            ->get();
    }

    public function storeSafetyFocuses(HealthSafetyFocusDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        HealthSafetyFocus::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $dto->date ? $dto->date : $shiftDate,
            ],
            [
                'note' => $dto->note,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Health and Safety Focus saved successfully',
            'step' => 11
        ]);
    }

    public function getFatalRiskToDiscuss($request)
    {
        return FatalRiskToDiscuss::with('fatalityRisk', 'fatalToDiscussControls')
            ->filterFatalRiskToDiscuss($request)
            ->get();
    }

    public function storeFatalRiskToDiscuss(FatalRiskToDiscussDto $dto)
    {
        $shiftDate = $this->getShiftDate();

        $discuss = FatalRiskToDiscuss::updateOrCreate(
            [
                'shift_id' => $dto->shift_id,
                'shift_rotation_id' => $dto->shift_rotation_id,
                'fatality_risk_id' => $dto->fatality_risk_id,
                'start_date' => $dto->start_date,
                'end_date' => $dto->end_date,
                'shift_type' => $dto->shift_type,
                'date' => $shiftDate,
            ],
            [
                'discuss_note' => $dto->discuss_note,
            ]
        );

        $discuss->fatalToDiscussControls()->delete();

        foreach ($dto->controls as $control) {
            $discuss->fatalToDiscussControls()->create([
                'description' => $control,
                'is_manual_entry' => false,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fatal Risk to Discuss saved successfully',
            'step' => 10
        ]);
    }

    public function getAllDiscussList($request)
    {
        $date = $this->getShiftDate();

        $discusses = FatalRiskToDiscuss::with('fatalityRisk', 'fatalToDiscussControls')
            ->where('shift_id', $request->shift_id)
            ->where('shift_rotation_id', $request->shift_rotation_id)
            ->where('start_date', Carbon::parse($request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::parse($request->end_date)->format('Y-m-d'))
            ->where('shift_type', $request->shift_type)
            ->where('date', $date)
            ->get();

        return view('components.admin.pick-a-fatal-risk-to-discuss.discuss-list', compact('discusses'));
    }

    public function getControlListForFatalRiskToDiscuss($request)
    {
        $date = $this->getShiftDate();

        $fatalityRiskId = $request->risk_id;
        $shiftId = $request->shift_id;
        $ShiftRotationId = $request->shift_rotation_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $shiftType = $request->shift_type;
        $parseStartDate = Carbon::parse($startDate)->format('Y-m-d');
        $parseEndDate = Carbon::parse($endDate)->format('Y-m-d');

        $fatalityRisk = FatalityRisk::findOrFail($fatalityRiskId);
        $controls = FatalityControl::where('fatality_risk_id', $fatalityRiskId)->get();

        $fatalRiskToDiscuss = FatalRiskToDiscuss::with('fatalToDiscussControls')
            ->where('fatality_risk_id', $fatalityRiskId)
            ->where('shift_id', $shiftId)
            ->where('shift_rotation_id', $ShiftRotationId)
            ->where('start_date', $parseStartDate)
            ->where('end_date', $parseEndDate)
            ->where('shift_type', $shiftType)
            ->where('date', $date)
            ->first();

        $selectedControls = $fatalRiskToDiscuss
            ? $fatalRiskToDiscuss->fatalToDiscussControls->pluck('description')->toArray()
            : [];

        $discussNote = $fatalRiskToDiscuss->discuss_note ?? null;

        return view('components.admin.pick-a-fatal-risk-to-discuss.control-list',
            compact('fatalityRisk', 'controls', 'shiftId', 'ShiftRotationId', 'startDate', 'endDate', 'shiftType',
                'selectedControls', 'discussNote'));
    }

    public function deleteTodayDiscussList($request)
    {
        $date = $this->getShiftDate();

        FatalRiskToDiscuss::where('shift_id', $request->shift_id)
            ->where('shift_rotation_id', $request->shift_rotation_id)
            ->where('start_date', Carbon::parse($request->start_date)->format('Y-m-d'))
            ->where('end_date', Carbon::parse($request->end_date)->format('Y-m-d'))
            ->where('shift_type', $request->shift_type)
            ->where('date', $date)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Discuss List deleted successfully',
            'step' => 10
        ]);
    }

    private function storeFatalityRiskControlToShiftLog($validated)
    {
        foreach ($validated['fatality_risk_control'] as $fatalityRiskControlId) {
            DB::table('shift_log_fatality_risk')->insert([
                'shift_log_id' => $validated['shift_log_id'],
                'fatality_risk_id' => $fatalityRiskControlId,
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
