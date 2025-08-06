<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\ShiftRotation;
use App\Models\SiteCommunication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteCommunicationController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.site-communication.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'dates' => [
                'required',
                'regex:/^(\d{2}-\d{2}-\d{4})(,\s*\d{2}-\d{2}-\d{4})*$/'
            ],
            'pdf' => ['required', 'file', 'mimes:pdf'],
            'shift_type' => ['required', Rule::in(['day_shift', 'night_shift'])]
        ]);

        $rotation = ShiftRotation::where('is_active', true)->firstOrFail();
        $dates = explode(',', $request->dates);
        $shiftType = $request->shift_type === 'day_shift' ? 'day' : 'night';

        foreach ($dates as $date) {
            $parsedDate = Carbon::createFromFormat('d-m-Y', trim($date));

            $shiftDetails = $rotation->getShiftBlocks($parsedDate, $parsedDate)->first();

            if (!$shiftDetails) {
                continue; // Skip if no shift found for that date
            }

            $shiftName = $shiftDetails[$request->shift_type] ?? null;

            if (!$shiftName) {
                continue; // Skip if shift name not found
            }

            $shift = Shift::where('name', $shiftName)->first();

            if (!$shift) {
                continue; // Skip if no matching shift record
            }

            $data = [
                'shift_id' => $shift->id,
                'shift_rotation_id' => $rotation->id,
                'start_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['start_date'])->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['end_date'])->format('Y-m-d'),
                'shift_type' => $shiftType,
                'date' => $parsedDate->format('Y-m-d'),
                'title' => $request->title,
                'description' => $request->description,
            ];

            // Handle file upload
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $data['path'] = $filePath;
            }

            SiteCommunication::create($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Site Communication created successfully'
        ]);
    }
}
