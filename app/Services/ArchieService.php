<?php

namespace App\Services;

use App\Models\CelebrateSuccess;
use App\Models\CelebrateSuccessArchive;
use App\Models\CrossCriteria;
use App\Models\FatalityControl;
use App\Models\FatalityControlArchive;
use App\Models\FatalityRisk;
use App\Models\FatalityRiskArchive;
use App\Models\FatalRiskToDiscuss;
use App\Models\FatalRiskToDiscussArchive;
use App\Models\FatalRiskToDiscussControlArchive;
use App\Models\HazardControl;
use App\Models\HazardControlArchive;
use App\Models\HealthSafetyCrossCriteria;
use App\Models\HealthSafetyCrossCriteriaArchive;
use App\Models\HealthSafetyFocus;
use App\Models\HealthSafetyFocusArchive;
use App\Models\HealthSafetyReview;
use App\Models\HealthSafetyReviewArchive;
use App\Models\ImproveOurPerformance;
use App\Models\ImproveOurPerformanceArchive;
use App\Models\LabourShift;
use App\Models\ReviewPreviousShift;
use App\Models\ReviewPreviousShiftArchive;
use App\Models\Shift;
use App\Models\ShiftLog;
use App\Models\ShiftLogArchive;
use App\Models\ShiftRotation;
use App\Models\SiteCommunication;
use App\Models\SiteCommunicationArchive;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchieService
{
    public function archivedHealthAndSafetyReview($date, $shift_type)
    {
        $healthSafetyReviews = HealthSafetyReview::with('shift', 'shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->get();

        if (!$healthSafetyReviews) {
            return;
        }

        foreach ($healthSafetyReviews as $review) {
            $formatedDate = Carbon::parse($date)->format('d-m-Y');
            $supervisor = $this->getSupervisorName($formatedDate, $review->shift_type);
            $labour = $this->getLabourNames($formatedDate, $review->shift_type);

            HealthSafetyReviewArchive::create([
                'crew' => $review->shift->name,
                'shift_rotation' => $review->shiftRotation->rotation_days,
                'start_date' => $this->changeDateFormat($review->start_date),
                'end_date' => $this->changeDateFormat($review->end_date),
                'shift_type' => $review->shift_type,
                'date' => $this->changeDateFormat($review->date),
                'question_number' => $review->question_number,
                'answer' => $review->answer,
                'supervisor_name' => $supervisor,
                'labour_name' => $labour,
            ]);
        }
    }

    public function archivedHealthAndSafetyCrossCriteria($date, $shift_type)
    {
        $criteria = HealthSafetyCrossCriteria::with('shift', 'shiftRotation', 'crossCriteria')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if (!$criteria) {
            return;
        }

        $formatedDate = Carbon::parse($date)->format('d-m-Y');
        $supervisor = $this->getSupervisorName($formatedDate, $criteria->shift_type);
        $labour = $this->getLabourNames($formatedDate, $criteria->shift_type);

        HealthSafetyCrossCriteriaArchive::create([
            'criteria_name' => $criteria->crossCriteria->name,
            'criteria_description' => $criteria->crossCriteria->description,
            'criteria_color' => $criteria->crossCriteria->color,
            'criteria_bg_color' => $criteria->crossCriteria->bg_color,
            'crew' => $criteria->shift->name,
            'shift_rotation' => $criteria->shiftRotation->rotation_days,
            'start_date' => $this->changeDateFormat($criteria->start_date),
            'end_date' => $this->changeDateFormat($criteria->end_date),
            'shift_type' => $criteria->shift_type,
            'date' => $this->changeDateFormat($criteria->date),
            'cell_number' => $criteria->cell_number,
            'supervisor_name' => $supervisor,
            'labour_name' => $labour,
        ]);

    }

    public function archivedReviewPreviousShift($date, $shift_type)
    {
        $reviewPreviousShifts = ReviewPreviousShift::with('shift', 'shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->get();

        if (!$reviewPreviousShifts) {
            return;
        }

        foreach ($reviewPreviousShifts as $previousShift) {
            $formatedDate = Carbon::parse($date)->format('d-m-Y');
            $supervisor = $this->getSupervisorName($formatedDate, $previousShift->shift_type);
            $labour = $this->getLabourNames($formatedDate, $previousShift->shift_type);

            ReviewPreviousShiftArchive::create([
                'crew' => $previousShift->shift->name,
                'shift_rotation' => $previousShift->shiftRotation->rotation_days,
                'start_date' => $this->changeDateFormat($previousShift->start_date),
                'end_date' => $this->changeDateFormat($previousShift->end_date),
                'shift_type' => $previousShift->shift_type,
                'date' => $this->changeDateFormat($previousShift->date),
                'question_number' => $previousShift->question_number,
                'answer' => $previousShift->answer,
                'supervisor_name' => $supervisor,
                'labour_name' => $labour,
            ]);
        }
    }

    public function archivedCelebrateSuccess($date, $shift_type)
    {
        $successNote = CelebrateSuccess::with('shift', 'shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if (!$successNote) {
            return;
        }

        $formatedDate = Carbon::parse($date)->format('d-m-Y');
        $supervisor = $this->getSupervisorName($formatedDate, $successNote->shift_type);
        $labour = $this->getLabourNames($formatedDate, $successNote->shift_type);

        CelebrateSuccessArchive::create([
            'crew' => $successNote->shift->name,
            'shift_rotation' => $successNote->shiftRotation->rotation_days,
            'start_date' => $this->changeDateFormat($successNote->start_date),
            'end_date' => $this->changeDateFormat($successNote->end_date),
            'shift_type' => $successNote->shift_type,
            'date' => $this->changeDateFormat($successNote->date),
            'note' => $successNote->note,
            'supervisor_name' => $supervisor,
            'labour_name' => $labour,
        ]);

    }

    public function archivedSiteCommunication($date, $shift_type)
    {
        $siteCommunications = SiteCommunication::with('shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->get();

        if (!$siteCommunications) {
            return;
        }

        foreach ($siteCommunications as $siteCommunication) {
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
                'crew' => $siteCommunication->shift,
                'shift_rotation' => $siteCommunication->shiftRotation->rotation_days,
                'start_date' => $this->changeDateFormat($siteCommunication->start_date),
                'end_date' => $this->changeDateFormat($siteCommunication->end_date),
                'shift_type' => $siteCommunication->shift_type,
                'date' => $this->changeDateFormat($siteCommunication->date),
                'title' => $siteCommunication->title,
                'description' => $siteCommunication->description,
                'path' => $newPath,
                'supervisor_name' => $supervisor,
                'labour_name' => $labour,
            ]);
        }
    }

    public function archivedShiftLog($date, $shift_type)
    {
        $formatedDate = Carbon::parse($date)->format('d-m-Y');
        $shiftLogs = ShiftLog::where('log_date', $formatedDate)
            ->where('shift_name', $shift_type)
            ->get();

        if (!$shiftLogs) {
            return;
        }

        foreach ($shiftLogs as $log) {
            $note = $this->getShiftLogNote($log->note_id);
            $shiftDetail = $this->getShiftDetails($date, $shift_type);
            $formatedDate = Carbon::parse($date)->format('d-m-Y');
            $supervisor = $this->getSupervisorName($formatedDate, $shift_type);
            $labour = $this->getLabourNames($formatedDate, $shift_type);
            $shiftLog = $this->storeShiftLogArchive($log, $note, $shiftDetail, $supervisor, $labour);

            if ($log->fatalityRiskControls) {
                foreach ($log->fatalityRiskControls as $risk) {
                    $fatalityRisk = FatalityRisk::with('hazardControls', 'fatalityControls')->find($risk->id);

                    $fatalRisk = $this->archivedFatalityRisk($risk->id);
                    $shiftLog->fatalityRisks()->attach($fatalRisk->id);

                    if ($fatalityRisk->fatalityControls) {
                        foreach ($fatalityRisk->fatalityControls as $control) {
                            FatalityControlArchive::create([
                                'fatality_risk_archive_id' => $fatalRisk->id,
                                'description' => $control->description,
                            ]);
                        }
                    }

                    if ($fatalityRisk->hazardControls) {
                        foreach ($fatalityRisk->hazardControls as $hazard) {
                            HazardControlArchive::create([
                                'shift_log_archive_id' => $shiftLog->id,
                                'fatality_risk_archive_id' => $fatalRisk->id,
                                'description' => $hazard->description,
                                'is_manual_entry' => $hazard->is_manual_entry,
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function storeShiftLogArchive($log, $note, $shiftDetail, $supervisor, $labour)
    {
        return ShiftLogArchive::create([
            'shift_name' => $log->shift_name,
            'crew' => $shiftDetail['crew'],
            'supervisor_name' => $supervisor,
            'labour_name' => $labour,
            'sh_start_date' => $shiftDetail['start_date'],
            'sh_end_date' => $shiftDetail['end_date'],
            'wo_number' => $log->wo_number,
            'asset_no' => $log->asset_no,
            'asset_description' => $log->asset_description,
            'work_description' => $log->work_description,
            'labour' => $log->labour,
            'duration' => $log->duration,
            'trades' => $log->trades,
            'due_start' => $log->due_start,
            'status' => $log->status,
            'raised' => $log->raised,
            'start_date' => $log->start_date,
            'priority' => $log->priority,
            'job_type' => $log->job_type,
            'department' => $log->department,
            'material_cost' => $log->material_cost,
            'labor_cost' => $log->labor_cost,
            'other_cost' => $log->other_cost,
            'is_excel_upload' => $log->is_excel_upload,
            'position' => $log->position,
            'supervisor_notes' => $log->supervisor_notes,
            'mark_as_complete' => $log->mark_as_complete,
            'progress' => $log->progress,
            'requisition' => $log->requisition,
            'log_date' => $log->log_date,
            'note' => $note,
            'critical_work' => $log->critical_work,
        ]);
    }

    public function archivedFatalityRisk($id)
    {
        $fatalityRisk = FatalityRisk::find($id);

        if (!$fatalityRisk) {
            return null;
        }

        $fatalityRiskArchive = FatalityRiskArchive::where('name', $fatalityRisk->name)->first();

        // copy image
        $newPath = $fatalityRiskArchive->image ?? null;

        // copy image if exists
        if ($fatalityRisk->image && Storage::disk('public')->exists($fatalityRisk->image)) {
            // delete old archive image if exists
            if ($fatalityRiskArchive && $fatalityRiskArchive->image && Storage::disk('public')->exists($fatalityRiskArchive->image)) {
                Storage::disk('public')->delete($fatalityRiskArchive->image);
            }

            $newPath = "archie/fatality-risk/{$fatalityRisk->name}/".basename($fatalityRisk->image);
            Storage::disk('public')->makeDirectory("archie/fatality-risk/{$fatalityRisk->name}");
            Storage::disk('public')->copy($fatalityRisk->image, $newPath);
        }

        if ($fatalityRiskArchive) {
            $fatalityRiskArchive->update([
                'name' => $fatalityRisk->name,
                'description' => $fatalityRisk->description,
                'image' => $newPath,
            ]);
        } else {
            $fatalityRiskArchive = FatalityRiskArchive::create([
                'name' => $fatalityRisk->name,
                'description' => $fatalityRisk->description,
                'image' => $newPath,
            ]);
        }

        return $fatalityRiskArchive;
    }

    public function archivedFatalityControl($id)
    {
        $fatalityControl = FatalityControl::find($id);

        if (!$fatalityControl) {
            return null;
        }

        $fatalityRiskArchive = $this->archivedFatalityRisk($fatalityControl->fatality_risk_id);

        if ($fatalityRiskArchive) {
            FatalityControlArchive::create([
                'fatality_risk_archive_id' => $fatalityRiskArchive->id,
                'description' => $fatalityControl->description,
            ]);
        }
    }

    public function archivedHazardControl($id)
    {
        $hazardControl = HazardControl::find($id);

        if (!$hazardControl) {
            return null;
        }

        $shiftLog = ShiftLog::find($hazardControl->shift_log_id);
        $fatalityRiskArchivedId = $this->getFatalityRiskArchivedId($hazardControl->fatality_risk_id);

        if (!$shiftLog) {
            return null;
        }

        $shiftLogArchived = ShiftLogArchive::where('wo_number', $shiftLog->wo_number)
            ->where('asset_no', $shiftLog->asset_no)
            ->first();

        if (!$shiftLogArchived) {
            return null;
        }

        HazardControlArchive::create([
            'shift_log_archive_id' => $shiftLogArchived->id,
            'fatality_risk_archive_id' => $fatalityRiskArchivedId,
            'description' => $hazardControl->description,
            'is_manual_entry' => $hazardControl->is_manual_entry,
        ]);
    }

    public function archivedImprovedOurPerformance($date, $shift_type)
    {
        $improvedPerformance = ImproveOurPerformance::with('shift', 'shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if (!$improvedPerformance) {
            return null;
        }

        $formatedDate = Carbon::parse($date)->format('d-m-Y');
        $supervisor = $this->getSupervisorName($formatedDate, $improvedPerformance->shift_type);
        $labour = $this->getLabourNames($formatedDate, $improvedPerformance->shift_type);

        ImproveOurPerformanceArchive::create([
            'crew' => $improvedPerformance->shift->name,
            'shift_rotation' => $improvedPerformance->shiftRotation->rotation_days,
            'start_date' => $this->changeDateFormat($improvedPerformance->start_date),
            'end_date' => $this->changeDateFormat($improvedPerformance->end_date),
            'shift_type' => $improvedPerformance->shift_type,
            'date' => $this->changeDateFormat($improvedPerformance->date),
            'issues' => $improvedPerformance->issues,
            'who' => $improvedPerformance->who,
            'supervisor_name' => $supervisor,
            'labour_name' => $labour,
        ]);
    }

    public function archivedHealthSafetyFocus($date, $shift_type)
    {
        $focus = HealthSafetyFocus::with('shift', 'shiftRotation')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if (!$focus) {
            return;
        }

        $formatedDate = Carbon::parse($date)->format('d-m-Y');
        $supervisor = $this->getSupervisorName($formatedDate, $focus->shift_type);
        $labour = $this->getLabourNames($formatedDate, $focus->shift_type);

        HealthSafetyFocusArchive::create([
            'crew' => $focus->shift->name,
            'shift_rotation' => $focus->shiftRotation->rotation_days,
            'start_date' => $this->changeDateFormat($focus->start_date),
            'end_date' => $this->changeDateFormat($focus->end_date),
            'shift_type' => $focus->shift_type,
            'date' => $this->changeDateFormat($focus->date),
            'note' => $focus->note,
            'supervisor_name' => $supervisor,
            'labour_name' => $labour,
        ]);
    }

    public function archivedFatalRiskToDiscuss($date, $shift_type)
    {
        $fatalRiskToDiscuss = FatalRiskToDiscuss::with('shift', 'shiftRotation', 'fatalityRisk',
            'fatalToDiscussControls')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->get();

        if (!$fatalRiskToDiscuss) {
            return;
        }

        foreach ($fatalRiskToDiscuss as $fatalRisk) {
            $formatedDate = Carbon::parse($date)->format('d-m-Y');
            $supervisor = $this->getSupervisorName($formatedDate, $fatalRisk->shift_type);
            $labour = $this->getLabourNames($formatedDate, $fatalRisk->shift_type);
            $fatalityRiskArchive = $this->archivedFatalityRisk($fatalRisk->fatality_risk_id);

            $fatal = FatalRiskToDiscussArchive::create([
                'crew' => $fatalRisk->shift->name,
                'shift_rotation' => $fatalRisk->shiftRotation->rotation_days,
                'fatality_risk_archive_id' => $fatalityRiskArchive->id,
                'start_date' => $this->changeDateFormat($fatalRisk->start_date),
                'end_date' => $this->changeDateFormat($fatalRisk->end_date),
                'shift_type' => $fatalRisk->shift_type,
                'date' => $this->changeDateFormat($fatalRisk->date),
                'discuss_note' => $fatalRisk->discuss_note,
                'supervisor_name' => $supervisor,
                'labour_name' => $labour,
            ]);

            if ($fatalRisk->fatalToDiscussControls) {
                foreach ($fatalRisk->fatalToDiscussControls as $discussControl) {
                    FatalRiskToDiscussControlArchive::create([
                        'fatal_risk_to_discuss_archive_id' => $fatal->id,
                        'description' => $discussControl?->description,
                        'is_manual_entry' => $discussControl->is_manual_entry,
                    ]);
                }
            }
        }
    }

    private function getShiftDetails($date, $shift_type)
    {
        $healthSafetyReview = HealthSafetyReview::with('shift')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if ($healthSafetyReview) {
            return [
                'crew' => $healthSafetyReview->shift->name,
                'start_date' => $this->changeDateFormat($healthSafetyReview->start_date),
                'end_date' => $this->changeDateFormat($healthSafetyReview->end_date),
            ];
        }

        $criteria = HealthSafetyCrossCriteria::with('shift')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if ($criteria) {
            return [
                'crew' => $criteria->shift->name,
                'start_date' => $this->changeDateFormat($criteria->start_date),
                'end_date' => $this->changeDateFormat($criteria->end_date),
            ];
        }

        $focus = HealthSafetyFocus::with('shift')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if ($focus) {
            return [
                'crew' => $focus->shift->name,
                'start_date' => $this->changeDateFormat($focus->start_date),
                'end_date' => $this->changeDateFormat($focus->end_date),
            ];
        }

        $review = ReviewPreviousShift::with('shift')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if ($review) {
            return [
                'crew' => $review->shift->name,
                'start_date' => $this->changeDateFormat($review->start_date),
                'end_date' => $this->changeDateFormat($review->end_date),
            ];
        }

        $improvedPerformance = ImproveOurPerformance::with('shift')
            ->where('date', $date)
            ->where('shift_type', $shift_type)
            ->first();

        if ($improvedPerformance) {
            return [
                'crew' => $improvedPerformance->shift->name,
                'start_date' => $this->changeDateFormat($improvedPerformance->start_date),
                'end_date' => $this->changeDateFormat($improvedPerformance->end_date),
            ];
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
        return ShiftRotation::find($id)?->rotation_days;
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

    /**
     * Get the shift log note by id
     * @param $id
     * @return mixed|null
     */
    private function getShiftLogNote($id = null)
    {
        if (is_null($id)) {
            return null;
        }

        return DB::connection('mysql1')
            ->table('notes')
            ->where('id', $id)
            ->value('note');
    }

    private function getFatalityRiskArchivedId($id)
    {
        $fatalityRisk = FatalityRisk::find($id);
        if (!$fatalityRisk) {
            return null;
        }
        $fatalityRiskArchive = FatalityRiskArchive::where('name', $fatalityRisk->name)->first();
        return $fatalityRiskArchive->id;
    }

    private function changeDateFormat($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
