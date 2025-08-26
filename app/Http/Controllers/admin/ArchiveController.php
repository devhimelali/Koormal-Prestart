<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\ArchieService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ArchiveController extends Controller
{
    public function __construct(public ArchieService $archieService)
    {
        //
    }

    public function archivedAllBoards(Request $request)
    {
        $date = $this->getShiftDate();
        $shift_type = $request->header('shift-type') ?? 'day';
        $data = $this->archieService->archivedReviewPreviousShift($date, $shift_type);
        return response()->json($data);
    }

    private function getShiftDate()
    {
        $timezone = Config::get('app.timezone', 'Australia/Perth');
        $now = Carbon::now($timezone);

        $sixAm = $now->copy()->startOfDay()->addHours(6);
        $sixPm = $now->copy()->startOfDay()->addHours(18);

        if ($now->between($sixAm, $sixPm)) {
            return $sixAm->format('Y-m-d');
        } elseif ($now->greaterThanOrEqualTo($sixPm)) {
            return $sixPm->format('Y-m-d');
        } else {
            return $sixPm->subDay()->format('Y-m-d');
        }
    }
}
