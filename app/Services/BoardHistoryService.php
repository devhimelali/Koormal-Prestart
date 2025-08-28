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

        $supervisor = $healthSafetyReviews->first()->last()->supervisor_name;
        $labour = $healthSafetyReviews->first()->last()->labour_name;
        $start_date = $healthSafetyReviews->first()->last()->start_date;
        $end_date = $healthSafetyReviews->first()->last()->end_date;
        $shift_type = $healthSafetyReviews->first()->last()->shift_type;
        $crew = $healthSafetyReviews->first()->last()->crew;

        return view('admin.boards-history.health-safety-review', [
            'healthSafetyReviewsQuestionOne' => $healthSafetyReviews->first(),
            'healthSafetyReviewsQuestionTwo' => $healthSafetyReviews->last(),
            'supervisor' => $supervisor,
            'labour' => $labour,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'shift_type' => $shift_type,
            'crew' => $crew,
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

        $crossCriteria = CrossCriteria::get();


        return view('admin.boards-history.health-safety-cross-criteria', [
            'healthSafetyCrossCriteria' => $healthSafetyCrossCriteria,
            'crossCriteria' => $crossCriteria,
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
            ->get();
    }

    public function getCelebrateSuccess(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $celebrateSuccesses = CelebrateSuccessArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
    }

    public function getSiteCommunication(BoardHistoryRequest $request)
    {
        $dates = $this->dateFormat($request->date_range);

        $siteCommunications = SiteCommunicationArchive::where('date', '>=', $dates['start_date'])
            ->where('date', '<=', $dates['end_date'])
            ->where('crew', $request->crew)
            ->where('shift_type', $request->shift)
            ->get();
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
