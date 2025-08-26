<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ArchiveController extends Controller
{
    public function archivedAllBoards(Request $request)
    {
        [ $date, $hour ] = $this->currentDateAndHour();
        if($hour > 18){

        }
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
