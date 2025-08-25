<?php

namespace App\Services;

use App\Models\CelebrateSuccess;
use App\Models\CelebrateSuccessArchive;
use App\Models\CrossCriteria;
use App\Models\HealthSafetyCrossCriteria;
use App\Models\HealthSafetyCrossCriteriaArchive;
use App\Models\HealthSafetyReview;
use App\Models\HealthSafetyReviewArchive;
use App\Models\LabourShift;
use App\Models\ReviewPreviousShift;
use App\Models\ReviewPreviousShiftArchive;
use App\Models\Shift;
use App\Models\ShiftRotation;
use App\Models\SiteCommunication;
use App\Models\SiteCommunicationArchive;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ArchieService
{
    /**
     * Archive the health and safety review
     * @param $dates
     * @return void
     */
    public function archivedHealthAndSafetyReview($dates)
    {
        foreach ($dates as $date) {
            $reviews = HealthSafetyReview::where('date', $date)->get();
            foreach ($reviews as $review) {
                $crew = $this->getShiftName($review->shift_id);
                $shiftRotation = $this->getShiftRotationDay($review->shift_rotation_id);
                $supervisor = $this->getSupervisorName($date, $review->shift_type);
                $labour = $this->getLabourNames($date, $review->shift_type);

                HealthSafetyReviewArchive::create([
                    'crew' => $crew,
                    'shift_rotation' => $shiftRotation,
                    'start_date' => $review->start_date,
                    'end_date' => $review->end_date,
                    'shift_type' => $review->shift_type,
                    'date' => $review->date,
                    'question_number' => $review->question_number,
                    'answer' => $review->answer,
                    'supervisor_name' => $supervisor,
                    'labour_name' => $labour,
                ]);
            }
        }
    }

    public function archivedHealthAndSafetyCrossCriteria($dates)
    {
        foreach ($dates as $date) {
            $crossCriteria = HealthSafetyCrossCriteria::where('date', $date)->get();
            foreach ($crossCriteria as $criteria) {
                $crew = $this->getShiftName($criteria->shift_id);
                $shiftRotation = $this->getShiftRotationDay($criteria->shift_rotation_id);
                $criteriaDetail = $this->getCrossCriteria($criteria->cross_criteria_id);
                $supervisor = $this->getSupervisorName($date, $criteria->shift_type);
                $labour = $this->getLabourNames($date, $criteria->shift_type);

                HealthSafetyCrossCriteriaArchive::create([
                    'criteria_name' => $criteriaDetail->name,
                    'criteria_description' => $criteriaDetail->description,
                    'criteria_color' => $criteriaDetail->color,
                    'criteria_bg_color' => $criteriaDetail->bg_color,
                    'crew' => $crew,
                    'shift_rotation' => $shiftRotation,
                    'start_date' => $criteria->start_date,
                    'end_date' => $criteria->end_date,
                    'shift_type' => $criteria->shift_type,
                    'date' => $criteria->date,
                    'cell_number' => $criteria->cell_number,
                    'supervisor_name' => $supervisor,
                    'labour_name' => $labour,
                ]);
            }
        }
    }

    public function archivedReviewPreviousShift($dates)
    {
        foreach ($dates as $date) {
            $previousShifts = ReviewPreviousShift::where('date', $date)->get();
            foreach ($previousShifts as $previousShift) {
                $crew = $this->getShiftName($previousShift->shift_id);
                $shiftRotation = $this->getShiftRotationDay($previousShift->shift_rotation_id);
                $supervisor = $this->getSupervisorName($date, $previousShift->shift_type);
                $labour = $this->getLabourNames($date, $previousShift->shift_type);

                ReviewPreviousShiftArchive::create([
                    'crew' => $crew,
                    'shift_rotation' => $shiftRotation,
                    'start_date' => $previousShift->start_date,
                    'end_date' => $previousShift->end_date,
                    'shift_type' => $previousShift->shift_type,
                    'date' => $previousShift->date,
                    'question_number' => $previousShift->question_number,
                    'answer' => $previousShift->answer,
                    'supervisor_name' => $supervisor,
                    'labour_name' => $labour,
                ]);
            }
        }
    }

    public function archivedCelebrateSuccess($dates)
    {
        foreach ($dates as $date) {
            $successNotes = CelebrateSuccess::where('date', $date)->get();

            foreach ($successNotes as $successNote) {
                $crew = $this->getShiftName($successNote->shift_id);
                $shiftRotation = $this->getShiftRotationDay($successNote->shift_rotation_id);
                $supervisor = $this->getSupervisorName($date, $successNote->shift_type);
                $labour = $this->getLabourNames($date, $successNote->shift_type);

                CelebrateSuccessArchive::create([
                    'crew' => $crew,
                    'shift_rotation' => $shiftRotation,
                    'start_date' => $successNote->start_date,
                    'end_date' => $successNote->end_date,
                    'shift_type' => $successNote->shift_type,
                    'date' => $successNote->date,
                    'note' => $successNote->note,
                    'supervisor_name' => $supervisor,
                    'labour_name' => $labour,
                ]);
            }
        }
    }

    public function ArchivedSiteCommunication($dates)
    {
        $siteCommunications = SiteCommunication::whereIn('date', $dates)
            ->orderBy('date')
            ->orderBy('shift_type')
            ->get()
            ->groupBy('date');

        foreach ($siteCommunications as $date => $communications) {
            foreach ($communications as $siteCommunication) {
                $crew = $this->getShiftName($siteCommunication->shift_id);
                $shiftRotation = $this->getShiftRotationDay($siteCommunication->shift_rotation_id);
                $formatedDate = Carbon::parse($date)->format('d-m-Y');
                $supervisor = $this->getSupervisorName($formatedDate, $siteCommunication->shift_type);
                $labour = $this->getLabourNames($formatedDate, $siteCommunication->shift_type);

                $newPath = null;
                if ($siteCommunication->path && Storage::disk('public')->exists($siteCommunication->path)) {
                    $newPath = "archie/{$date}/".basename($siteCommunication->path);
                    Storage::disk('public')->makeDirectory("archie/{$date}");
                    Storage::disk('public')->copy($siteCommunication->path, $newPath);
                }

                SiteCommunicationArchive::create([
                    'crew' => $crew,
                    'shift_rotation' => $shiftRotation,
                    'start_date' => $siteCommunication->start_date,
                    'end_date' => $siteCommunication->end_date,
                    'shift_type' => $siteCommunication->shift_type,
                    'date' => $siteCommunication->date,
                    'path' => $newPath,
                    'supervisor_name' => $supervisor,
                    'labour_name' => $labour,
                ]);
            }
        }
    }

    /**
     * Get the shift name by id
     * @param $id
     * @return string
     */
    private function getShiftName($id): string
    {
        return Shift::find($id)?->name;
    }

    /**
     * Get the shift rotation day by id
     * @param $id
     * @return string
     */
    private function getShiftRotationDay($id): string
    {
        return ShiftRotation::find($id)?->day;
    }

    /**
     * Get the cross criteria by id
     * @param $id
     * @return mixed
     */
    private function getCrossCriteria($id)
    {
        return CrossCriteria::find($id);
    }

    /**
     * Get the supervisor name by date and shift
     * @param $date
     * @param $shift
     * @return string
     */
    private function getSupervisorName($date, $shift): string
    {
        return Supervisor::where('date', $date)
            ->where('shift', $shift)
            ->value('name');
    }

    /**
     * Get the labour names by date and shift
     * @param $date
     * @param $shift
     * @return string
     */
    private function getLabourNames($date, $shift): string
    {
        return LabourShift::where('date', $date)
            ->where('shift', $shift)
            ->value('name');
    }
}
