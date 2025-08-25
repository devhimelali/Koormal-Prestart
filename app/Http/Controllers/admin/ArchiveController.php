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

    private function currentDateAndHour()
    {
        $timezone = Config::get('app.timezone', 'Australia/Perth');
        $now = Carbon::now($timezone);
        $hour = $now->hour;
        $date = $now->copy()->format('Y-m-d');
        return [$date, $hour];
    }
}
