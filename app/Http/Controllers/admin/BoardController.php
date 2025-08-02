<?php

namespace App\Http\Controllers\admin;

use App\DTOs\HealthSafetyReviewCrossCriteriaDto;
use App\DTOs\HealthSafetyReviewDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\HealthSafetyReviewCrossCriteriaRequest;
use App\Http\Requests\HealthSafetyReviewRequest;
use App\Http\Requests\ShowBoardRequest;
use App\Models\DailyShiftEntry;
use App\Models\FatalityRiskControl;
use App\Services\BoardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function __construct(public BoardService $boardService)
    {
        //code here
    }

    public function index(Request $request)
    {
        return view('admin.boards.index');
    }

    public function updateSupervisorName(Request $request)
    {
        $this->boardService->saveSupervisorName($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Supervisor name updated successfully',
        ]);
    }

    public function show(ShowBoardRequest $request)
    {
        $step = $request->step;
        $timezone = Config::get('app.timezone', 'Australia/Perth');
        $now = Carbon::now($timezone);
        $hour = $now->hour;

        $isDayShiftTime = $hour >= 6 && $hour < 18;
        $isNightShiftTime = $hour >= 18 || $hour < 6;

        if ($step == 1) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReviewForQuestionOne($request);
            // Check if the current time is between 6AM and 6PM for day shift
            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.health-safety-review-question-one', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => false
                ])->render();
                // Check if the current time is between 6PM and 6AM for night shift
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.health-safety-review-question-one', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.health-safety-review-question-one', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 2) {
            $healthSafetyReview = $this->boardService->getHealthSafetyReviewForQuestionTwo($request);
            // Check if the current time is between 6AM and 6PM for day shift
            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.health-safety-review-question-two', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => false
                ])->render();
                // Check if the current time is between 6PM and 6AM for night shift
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.health-safety-review-question-two', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.health-safety-review-question-two', [
                    'healthSafetyReview' => $healthSafetyReview,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 3) {
            $crossCriteria = $this->boardService->getCrossCriteria();
            $safetyCalendar = $this->boardService->getSafetyCalendarData($request);

            return view('admin.boards.health-safety-cross-criteria', [
                'crossCriteria' => $crossCriteria,
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
        } elseif ($step == 8) {
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

    public function storeHealthSafetyReview(HealthSafetyReviewRequest $request)
    {
        $this->boardService->storeHealthSafetyReview(HealthSafetyReviewDto::fromArray($request->validated()));

        $step = $request->question_number == 'question_one' ? 1 : 2;
        return response()->json([
            'status' => 'success',
            'message' => 'Health and Safety Review saved successfully',
            'step' => $step
        ]);
    }

    public function storeHealthSafetyCrossCriteria(HealthSafetyReviewCrossCriteriaRequest $request)
    {
        return $this->boardService->storeHealthSafetyCrossCriteria(HealthSafetyReviewCrossCriteriaDto::fromArray($request->validated()));
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

    public function deleteFatalityRiskControlImage(Request $request)
    {
        DB::table('shift_log_fatality_risk_control')->where('shift_log_id',
            $request->shift_log_id)->where('fatality_risk_control_id', $request->fatality_risk_control_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control image deleted successfully',
        ]);
    }
}


