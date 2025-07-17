<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ShiftRotation;
use App\Http\Controllers\Controller;

class RosterController extends Controller
{
    public function showNextMonthSchedule()
    {
        $rotation = ShiftRotation::where('is_active', true)->first();

        if (!$rotation) {
            return view('admin.rosters.index', ['blocks' => collect()]);
        }

        $startDate = now()->startOfDay();
        $endDate = now()->addMonth()->endOfDay();

        $blocks = $rotation->getShiftBlocks($startDate, $endDate);

        return view('admin.rosters.index', compact('blocks'));
    }
}
