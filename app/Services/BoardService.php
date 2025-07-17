<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\DailyShiftEntry;

class BoardService
{
    public function saveSupervisorName(Request $request)
    {
        $dailyShiftEntry = DailyShiftEntry::find($request->daily_shift_entry_id);
        $dailyShiftEntry->supervisor_name = $request->supervisor_name;
        $dailyShiftEntry->save();
    }
}
