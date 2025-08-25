<?php

namespace App\Services;

use App\Models\HealthSafetyReview;
use App\Models\HealthSafetyReviewArchive;
use App\Models\LabourShift;
use App\Models\Shift;
use App\Models\ShiftRotation;
use App\Models\Supervisor;

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
