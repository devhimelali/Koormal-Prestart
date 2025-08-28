<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardHistoryRequest;
use App\Models\FatalityRiskArchive;
use App\Models\HazardControlArchive;
use App\Models\Shift;
use App\Services\BoardHistoryService;
use Illuminate\Http\Request;

class BoardHistoryController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(public BoardHistoryService $boardHistoryService)
    {
        //
    }

    public function history()
    {
        $boards = [
            "review_health_safety" => "Review of Health & Safety",
            "cross_criteria" => "Health & Safety Cross Criteria",
            "previous_shift" => "Review of Previous Shift",
            "celebrate_success" => "Celebrate Success",
            "site_communication" => "Site Communication",
            "fatality_risk" => "Fatality Risk Management",
            "improve_performance" => "Improve Our Performance",
            "pick_fatal_risk" => "Pick a Fatal Risk to Discuss",
            "safety_focus" => "Health and Safety Focus",
        ];


        return view('admin.boards-history.index', [
            'crews' => Shift::orderBy('name')->get(),
            'boards' => $boards,
        ]);
    }

    public function getBoardHistoryList(BoardHistoryRequest $request)
    {
        return match ($request->board) {
            'review_health_safety' => $this->boardHistoryService->getReviewOfHealthSafety($request),
            'cross_criteria' => $this->boardHistoryService->getHealthSafetyCrossCriteria($request),
            'previous_shift' => $this->boardHistoryService->getReviewOfPreviousShift($request),
            'celebrate_success' => $this->boardHistoryService->getCelebrateSuccess($request),
            'site_communication' => $this->boardHistoryService->getSiteCommunication($request),
            'fatality_risk' => $this->boardHistoryService->getFatalityRiskManagement($request),
            'improve_performance' => $this->boardHistoryService->getImproveOurPerformance($request),
            'pick_fatal_risk' => $this->boardHistoryService->getFatalRiskToDiscuss($request),
            'safety_focus' => $this->boardHistoryService->getHealthAndSafetyFocus($request),
            default => response()->json(['message' => 'Invalid board'], 400),
        };
    }

    public function getHazardControlListArchive(Request $request)
    {
        $fatalityRisk = FatalityRiskArchive::find($request->fatality_risk_id);
        $controls = HazardControlArchive::where('shift_log_archive_id', $request->shift_log_id)
            ->where('fatality_risk_archive_id', $request->fatality_risk_id)
            ->get();

        return view('admin.boards-history.control-list', [
            'controls' => $controls,
            'fatalityRisk' => $fatalityRisk,
        ]);
    }

}
