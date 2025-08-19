<?php

namespace App\Http\Controllers\admin;

use App\DTOs\CelebrateSuccessDto;
use App\DTOs\FatalRiskToDiscussDto;
use App\DTOs\HealthSafetyFocusDto;
use App\DTOs\HealthSafetyReviewCrossCriteriaDto;
use App\DTOs\HealthSafetyReviewDto;
use App\DTOs\ImproveOurPerformanceDto;
use App\DTOs\ReviewOfPreviousShiftDto;
use App\DTOs\SiteCommunicationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CelebrateSuccessRequest;
use App\Http\Requests\FatalRiskToDiscussRequest;
use App\Http\Requests\HealthSafetyFocusRequest;
use App\Http\Requests\HealthSafetyReviewCrossCriteriaRequest;
use App\Http\Requests\HealthSafetyReviewRequest;
use App\Http\Requests\ImproveOurPerformanceRequest;
use App\Http\Requests\ReviewOfPreviousShiftRequest;
use App\Http\Requests\ShowBoardRequest;
use App\Http\Requests\SiteCommunicationRequest;
use App\Models\DailyShiftEntry;
use App\Models\FatalityControl;
use App\Models\FatalityRisk;
use App\Models\HazardControl;
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
        $supervisor = $this->boardService->getSupervisorName($request->shift_type, Carbon::now()->format('d-m-Y'));
        $labor = $this->boardService->getLaborName($request->shift_type, Carbon::now()->format('d-m-Y'));
        return view('admin.boards.index', compact('supervisor', 'labor'));
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

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.health-safety-cross-criteria', [
                    'crossCriteria' => $crossCriteria,
                    'safetyCalendar' => $safetyCalendar,
                    'disabled' => false
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.health-safety-cross-criteria', [
                    'crossCriteria' => $crossCriteria,
                    'safetyCalendar' => $safetyCalendar,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.health-safety-cross-criteria', [
                    'crossCriteria' => $crossCriteria,
                    'safetyCalendar' => $safetyCalendar,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 4) {
            $productiveQuestionOne = $this->boardService->getProductiveQuestionOne($request);

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.review_of_previous_shift_question_one', [
                    'productiveQuestionOne' => $productiveQuestionOne,
                    'disabled' => false
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.review_of_previous_shift_question_one', [
                    'productiveQuestionOne' => $productiveQuestionOne,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.review_of_previous_shift_question_one', [
                    'productiveQuestionOne' => $productiveQuestionOne,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 5) {
            $productiveQuestionTwo = $this->boardService->getProductiveQuestionTwo($request);
            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.review_of_previous_shift_question_two', [
                    'productiveQuestionTwo' => $productiveQuestionTwo,
                    'disabled' => false
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.review_of_previous_shift_question_two', [
                    'productiveQuestionTwo' => $productiveQuestionTwo,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.review_of_previous_shift_question_two', [
                    'productiveQuestionTwo' => $productiveQuestionTwo,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 6) {
            $celebrateSuccesses = $this->boardService->getCelebrateSuccesses($request);

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.celebrate_success', [
                    'celebrateSuccesses' => $celebrateSuccesses,
                    'disabled' => false
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.celebrate_success', [
                    'celebrateSuccesses' => $celebrateSuccesses,
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.celebrate_success', [
                    'celebrateSuccesses' => $celebrateSuccesses,
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 7) {
            $siteCommunications = $this->boardService->getSiteCommunications($request);

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.site_communication', [
                    'siteCommunications' => $siteCommunications,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false,
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.site_communication', [
                    'siteCommunications' => $siteCommunications,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.site_communication', [
                    'siteCommunications' => $siteCommunications,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 8) {
            $date = Carbon::now()->format('d-m-Y');
            $shiftLogs = $this->boardService->getShiftLog($request->shift_type, $date);
            $fatalityRisks = FatalityRisk::orderBy('name', 'asc')->get();
            return view('admin.boards.fatality-risk-management', [
                'shiftLogs' => $shiftLogs,
                'shift' => $request->shift_type,
                'fatalityRisks' => $fatalityRisks
            ])->render();
        } elseif ($step == 9) {
            $improvePerformances = $this->boardService->getImprovePerformances($request);

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.improve-our-performance', [
                    'improvePerformances' => $improvePerformances,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false,
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.improve-our-performance', [
                    'improvePerformances' => $improvePerformances,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.improve-our-performance', [
                    'improvePerformances' => $improvePerformances,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => true
                ])->render();
            }
        } elseif ($step == 10) {
            $fatalityRisks = FatalityRisk::orderBy('name')->get();
            $discusses = $this->boardService->getFatalRiskToDiscuss($request);

            return view('admin.boards.pick-a-fatal-risk-to-discuss', [
                'fatalityRisks' => $fatalityRisks,
                'discusses' => $discusses,
            ]);
        } elseif ($step == 11) {
            $safetyFocuses = $this->boardService->getSafetyFocuses($request);

            if ($request->shift_type === 'day' && $isDayShiftTime) {
                return view('admin.boards.health-and-safety-focus', [
                    'safetyFocuses' => $safetyFocuses,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false,
                ])->render();
            } elseif ($request->shift_type === 'night' && $isNightShiftTime) {
                return view('admin.boards.health-and-safety-focus', [
                    'safetyFocuses' => $safetyFocuses,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => false
                ])->render();
            } else {
                return view('admin.boards.health-and-safety-focus', [
                    'safetyFocuses' => $safetyFocuses,
                    'today' => Carbon::now()->format('d-m-Y'),
                    'disabled' => true
                ])->render();
            }
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

    public function storeProductiveQuestion(ReviewOfPreviousShiftRequest $request)
    {
        return $this->boardService->storeProductiveQuestion(ReviewOfPreviousShiftDto::fromArray($request->validated()));
    }

    public function storeCelebrateSuccess(CelebrateSuccessRequest $request)
    {
        return $this->boardService->storeCelebrateSuccess(CelebrateSuccessDto::fromArray($request->validated()));
    }

    public function storeSiteCommunication(SiteCommunicationRequest $request)
    {
        return $this->boardService->storeSiteCommunication(SiteCommunicationDto::fromArray($request->validated()));
    }

    public function resetSafetyCalendar(Request $request)
    {
        return $this->boardService->resetSafetyCalendar($request);
    }

    public function getSupervisorAndLabourList($shift_type)
    {
        $date = Carbon::now()->format('d-m-Y');
        $supervisor = $this->boardService->getSupervisorName($shift_type, $date);
        $labor = $this->boardService->getLaborName($shift_type, $date);
        return view('components.admin.boards.supervisor-labour-name', compact('supervisor', 'labor'));
    }

    public function assignFatalityRiskControl(Request $request)
    {
        return $this->boardService->assignFatalityRiskControl($request);
    }

    public function deleteFatalityRiskControlImage(Request $request)
    {
        DB::table('shift_log_fatality_risk')->where('shift_log_id',
            $request->shift_log_id)->where('fatality_risk_id', $request->fatality_risk_control_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control image deleted successfully',
        ]);
    }

    public function getHazardControlList(Request $request)
    {
        $request->validate([
            'fatality_risk_id' => 'required|exists:fatality_risks,id',
            'shift_log_id' => 'required'
        ]);

        $shiftLogId = $request->shift_log_id;
        $hazardControls = $this->boardService->getHazardControlsByFatalityRisk($request->fatality_risk_id,
            $request->shift_log_id);
        $fatalityRisk = FatalityRisk::find($request->fatality_risk_id);

        return view('components.admin.hazard-controls.list',
            compact('hazardControls', 'fatalityRisk', 'shiftLogId'))->render();
    }

    public function storeHazardControl(Request $request)
    {
        $request->validate([
            'fatality_risk_id' => 'required|exists:fatality_risks,id',
            'shift_log_id' => 'required',
            'description' => 'required|string',
        ]);

        HazardControl::create([
            'fatality_risk_id' => $request->fatality_risk_id,
            'shift_log_id' => $request->shift_log_id,
            'description' => $request->description,
            'is_manual_entry' => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Control added successfully',
        ]);
    }

    public function destroyHazardControl(Request $request)
    {
        $hazard = HazardControl::findOrFail($request->id);
        $hazard->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Hazard Control deleted successfully',
        ]);
    }

    public function getFatalityControlList(Request $request)
    {
        $fatalityRiskId = $request->fatality_risk_id;
        $shiftLogId = $request->shift_log_id;
        $fatalityControls = $this->boardService->getFatalityControlsByFatalityRisk($fatalityRiskId);
        $savedControls = \DB::table('hazard_controls')
            ->where('shift_log_id', $shiftLogId)
            ->where('fatality_risk_id', $fatalityRiskId)
            ->pluck('description')
            ->toArray();


        return view('components.admin.hazard-controls.control-list',
            compact('fatalityControls', 'savedControls', 'fatalityRiskId', 'shiftLogId'))->render();
    }

    public function storeFatalityControl(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'fatality_risk_id' => 'required|exists:fatality_risks,id',
            'shift_log_id' => 'required|integer',
            'controls' => 'required|array',
            'controls.*' => 'required|string',
        ]);

        $shiftLogId = $request->shift_log_id;
        $fatalityRiskId = $request->fatality_risk_id;

        // Delete hazard controls not in the current request
        HazardControl::where('shift_log_id', $shiftLogId)
            ->where('fatality_risk_id', $fatalityRiskId)
            ->whereNotIn('description', $request->controls)
            ->where('is_manual_entry', 0)
            ->delete();

        // Add or keep requested controls
        foreach ($request->controls as $control) {
            HazardControl::updateOrCreate(
                [
                    'shift_log_id' => $shiftLogId,
                    'fatality_risk_id' => $fatalityRiskId,
                    'description' => $control,
                ],
                [
                    'is_manual_entry' => 0,
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Controls added successfully',
        ]);
    }

    public function storeImprovePerformance(ImproveOurPerformanceRequest $request)
    {
        return $this->boardService->storeImprovePerformance(ImproveOurPerformanceDto::fromArray($request->validated()));
    }

    public function storeSafetyFocuses(HealthSafetyFocusRequest $request)
    {
        return $this->boardService->storeSafetyFocuses(HealthSafetyFocusDto::fromArray($request->validated()));
    }

    public function storeFatalRiskToDiscuss(FatalRiskToDiscussRequest $request)
    {
        return $this->boardService->storeFatalRiskToDiscuss(FatalRiskToDiscussDto::fromArray($request->validated()));
    }

    public function getControlListForFatalRiskToDiscuss(Request $request)
    {
        $fatalityRiskId = $request->risk_id;
        $shiftId = $request->shift_id;
        $ShiftRotationId = $request->shift_rotation_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $shiftType = $request->shift_type;

        $fatalityRisk = FatalityRisk::findOrFail($fatalityRiskId);
        $controls = FatalityControl::where('fatality_risk_id', $fatalityRiskId)->get();

        return view('components.admin.pick-a-fatal-risk-to-discuss.control-list',
            compact('fatalityRisk', 'controls', 'shiftId', 'ShiftRotationId', 'startDate', 'endDate', 'shiftType'));
    }
}


