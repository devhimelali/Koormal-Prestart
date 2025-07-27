<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DailyShiftEntry;
use App\Models\FatalityRiskControl;
use App\Services\BoardService;
use Carbon\Carbon;
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
            $healthSafetyReview = $this->boardService->getHealthSafetyReviewForQuestionOne($request);

            return view('admin.boards.health-safety-review-question-one', [
                'healthSafetyReview' => $healthSafetyReview
            ])->render();
        } elseif ($step == 2) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReviewForQuestionTwo($request);

            return view('admin.boards.health-safety-review-question-two', [
                'healthSafetyReview' => $healthSafetyReview
            ])->render();
        } elseif ($step == 3) {
            $crossCriteria = $this->boardService->getCrossCriteria();
            $safetyCalendar = $this->boardService->getSafetyCalendarData();

            return view('admin.boards.health-safety-cross-criteria', [
                'crossCriteria' => $crossCriteria,
                'dailyShiftEntryId' => $dailyShiftEntryId,
                'safetyCalendar' => $safetyCalendar
            ])->render();
        } elseif ($step == 4) {
            $productiveQuestionOne = $this->boardService->getProductiveQuestionOne($request);
            return view('admin.boards.review_of_previous_shift_question_one', [
                'productiveQuestionOne' => $productiveQuestionOne
            ])->render();
        } elseif ($step == 5) {
            $productiveQuestionTwo = $this->boardService->getProductiveQuestionTwo($request);
            return view('admin.boards.review_of_previous_shift_question_two', [
                'productiveQuestionTwo' => $productiveQuestionTwo
            ])->render();
        } elseif ($step == 6) {
            $celebrateSuccesses = $this->boardService->getCelebrateSuccesses($request);
            return view('admin.boards.celebrate_success', [
                'celebrateSuccesses' => $celebrateSuccesses
            ])->render();
        } elseif ($step == 7) {
            $siteCommunications = $this->boardService->getSiteCommunications($request);
            return view('admin.boards.site_communication', [
                'siteCommunications' => $siteCommunications
            ])->render();
        }elseif ($step == 8) {
            $dailyShiftEntry = DailyShiftEntry::findOrFail($dailyShiftEntryId);
            $shift = $dailyShiftEntry->shift_type;
            $date = Carbon::parse($dailyShiftEntry->date)->format('d-m-Y');
            $shiftLogs = $this->boardService->getShiftLog($shift, $date);
            $fatalityRisks = FatalityRiskControl::orderBy('name', 'asc')->get();
            return view('admin.boards.fatality-risk-management', [
                'shiftLogs' => $shiftLogs,
                'shift' => $shift,
                'fatalityRisks' => $fatalityRisks
            ])->render();
        }
    }

    public function storeHealthSafetyReview(Request $request)
    {
        $this->boardService->storeHealthSafetyReview($request);
        $step = $request->question_number == 'question_one' ? 1 : 2;
        return response()->json([
            'status' => 'success',
            'message' => 'Health and Safety Review saved successfully',
            'step' => $step
        ]);
    }

    public function storeHealthSafetyCrossCriteria(Request $request)
    {
        return $this->boardService->storeHealthSafetyCrossCriteria($request);
    }

    public function storeProductiveQuestion(Request $request)
    {
        return $this->boardService->storeProductiveQuestion($request);
    }

    public function storeCelebrateSuccess(Request $request)
    {
        return $this->boardService->storeCelebrateSuccess($request);
    }
    public function storeSiteCommunication(Request $request)
    {
        return $this->boardService->storeSiteCommunication($request);
    }

    public function resetSafetyCalendar(Request $request)
    {
        return $this->boardService->resetSafetyCalendar($request);
    }

    public function getSupervisorAndLabourList($daily_shift_entry_id)
    {
        $dailyShiftEntry = DailyShiftEntry::findOrFail($daily_shift_entry_id);
        $shift = $dailyShiftEntry->shift_type;
        $date = Carbon::parse($dailyShiftEntry->date)->format('d-m-Y');
        $supervisor = $this->boardService->getSupervisorName($shift, $date);
        $labor = $this->boardService->getLaborName($shift, $date);
        return view('components.admin.boards.supervisor-labour-name', compact('supervisor', 'labor'));
    }

    public function assignFatalityRiskControl(Request $request)
    {
        return $this->boardService->assignFatalityRiskControl($request);
    }
}


