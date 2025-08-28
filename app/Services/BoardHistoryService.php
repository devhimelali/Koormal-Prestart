<?php

namespace App\Services;

use App\Http\Requests\BoardHistoryRequest;
use App\Models\CelebrateSuccessArchive;
use App\Models\CrossCriteria;
use App\Models\FatalRiskToDiscussArchive;
use App\Models\HealthSafetyCrossCriteriaArchive;
use App\Models\HealthSafetyFocusArchive;
use App\Models\HealthSafetyReviewArchive;
use App\Models\ImproveOurPerformanceArchive;
use App\Models\ReviewPreviousShiftArchive;
use App\Models\ShiftLogArchive;
use App\Models\SiteCommunicationArchive;

class BoardHistoryService
{
    public function getReviewOfHealthSafety(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $healthSafetyReviews = HealthSafetyReviewArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get()
            ->groupBy('question_number');

        return view('admin.boards-history.health-safety-review', [
            'healthSafetyReviewsQuestionOne' => $healthSafetyReviews->first(),
            'healthSafetyReviewsQuestionTwo' => $healthSafetyReviews->last(),
            'supervisor' => $healthSafetyReviews->first()->last()->supervisor_name,
            'labour' => $healthSafetyReviews->first()->last()->labour_name,
            'start_date' => $healthSafetyReviews->first()->last()->start_date,
            'end_date' => $healthSafetyReviews->first()->last()->end_date,
            'shift_type' => $healthSafetyReviews->first()->last()->shift_type,
            'crew' => $healthSafetyReviews->first()->last()->crew,
        ]);
    }

    public function getHealthSafetyCrossCriteria(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $healthSafetyCrossCriteria = HealthSafetyCrossCriteriaArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();

        return view('admin.boards-history.health-safety-cross-criteria', [
            'healthSafetyCrossCriteria' => $healthSafetyCrossCriteria,
            'crossCriteria' => CrossCriteria::get(),
            'supervisor' => $healthSafetyCrossCriteria->last()->supervisor_name,
            'labour' => $healthSafetyCrossCriteria->last()->labour_name,
            'start_date' => $healthSafetyCrossCriteria->last()->start_date,
            'end_date' => $healthSafetyCrossCriteria->last()->end_date,
            'shift_type' => $healthSafetyCrossCriteria->last()->shift_type,
            'crew' => $healthSafetyCrossCriteria->last()->crew,
        ]);
    }

    public function getReviewOfPreviousShift(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $reviewOfPreviousShifts = ReviewPreviousShiftArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->orderBy('question_number')
            ->get()
            ->groupBy('question_number');

        return view('admin.boards-history.review-of-previous-shift', [
            'reviewOfPreviousShiftsQuestionOne' => $reviewOfPreviousShifts->first(),
            'reviewOfPreviousShiftsQuestionTwo' => $reviewOfPreviousShifts->last(),
            'supervisor' => $reviewOfPreviousShifts->first()->last()->supervisor_name,
            'labour' => $reviewOfPreviousShifts->first()->last()->labour_name,
            'start_date' => $reviewOfPreviousShifts->first()->last()->start_date,
            'end_date' => $reviewOfPreviousShifts->first()->last()->end_date,
            'shift_type' => $reviewOfPreviousShifts->first()->last()->shift_type,
            'crew' => $reviewOfPreviousShifts->first()->last()->crew,
        ]);
    }

    public function getCelebrateSuccess(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $celebrateSuccesses = CelebrateSuccessArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();

        return view('admin.boards-history.celebrate-success', [
            'celebrateSuccesses' => $celebrateSuccesses,
            'supervisor' => $celebrateSuccesses->last()->supervisor_name,
            'labour' => $celebrateSuccesses->last()->labour_name,
            'start_date' => $celebrateSuccesses->last()->start_date,
            'end_date' => $celebrateSuccesses->last()->end_date,
            'shift_type' => $celebrateSuccesses->last()->shift_type,
            'crew' => $celebrateSuccesses->last()->crew,
        ]);
    }

    public function getSiteCommunication(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $siteCommunications = SiteCommunicationArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();

        return view('admin.boards-history.site-communication', [
            'siteCommunications' => $siteCommunications,
            'supervisor' => $siteCommunications->last()->supervisor_name,
            'labour' => $siteCommunications->last()->labour_name,
            'start_date' => $siteCommunications->last()->start_date,
            'end_date' => $siteCommunications->last()->end_date,
            'shift_type' => $siteCommunications->last()->shift_type,
            'crew' => $siteCommunications->last()->crew,
        ]);
    }

    public function getFatalityRiskManagement(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $fatalityRiskManagements = ShiftLogArchive::with('hazardControlArchives', 'fatalityRisks')
            ->where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
    }

    public function getImproveOurPerformance(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $improveOurPerformances = ImproveOurPerformanceArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
    }

    public function getFatalRiskToDiscuss(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $fatalRiskToDiscusses = FatalRiskToDiscussArchive::with('fatalityRiskArchive',
            'fatalRiskToDiscussControlArchives')
            ->where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
    }

    public function getHealthAndSafetyFocus(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $healthSafetyFocuses = HealthSafetyFocusArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
    }

    private function dateFormat($date)
    {
        $dateArray = explode(' to ', $date);

        return [
            'start_date' => $dateArray[0],
            'end_date' => $dateArray[1],
        ];
    }
}
