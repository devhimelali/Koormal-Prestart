<?php

namespace App\Http\Controllers\admin;

use App\Enums\ShiftTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteCommunicationRequest;
use App\Models\Shift;
use App\Models\ShiftRotation;
use App\Models\SiteCommunication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SiteCommunicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SiteCommunication::with('shiftRotation')
                ->when($request->filled('shift'), function ($query) use ($request) {
                    $query->where('shift', $request->shift);
                })
                ->when($request->filled('shift_type'), function ($query) use ($request) {
                    if ($enum = ShiftTypeEnum::tryFrom($request->shift_type)) {
                        $query->where('shift_type', $enum);
                    }
                });

            $startDate = $request->start_date;
            $endDate = $request->end_date;

            if ($startDate && $endDate) {
                $data->whereBetween('date', [$startDate, $endDate]);
            } else {
                $startDate = Carbon::today()->subDays(7)->startOfDay();
                $endDate = Carbon::today()->endOfDay();
                $data->whereBetween('date', [$startDate, $endDate]);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('shift', function ($row) {
                    return $row->shift;
                })
                ->addColumn('shift_type', function ($row) {
                    return $row->shift_type->value === 'day' ? 'Day Shift' : 'Night Shift';
                })
                ->addColumn('actions', function ($row) {
                    $buttons = '<div class="btn-group">';

                    if ($row->path) {
                        $viewUrl = route('site-communications.show', $row->id);
                        $pdfUrl = asset('storage/'.$row->path);

                        $buttons .= '<a href="'.$viewUrl.'" target="_blank" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-file-earmark-pdf"></i> View PDF
                                     </a>';
                        $buttons .= '<a href="'.$pdfUrl.'" target="_blank" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-download"></i> Download PDF
                                     </a>';
                    }

                    $buttons .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-warning btn-sm d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i> Edit
                                  </a>';
                    $buttons .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="bi bi-trash"></i> Delete
                                  </a>';

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $shifts = Shift::all();
        $shiftTypes = ShiftTypeEnum::cases();

        return view('admin.site-communication.index', compact('shifts', 'shiftTypes'));
    }

    public function store(SiteCommunicationRequest $request)
    {
        $rotation = ShiftRotation::where('is_active', true)->firstOrFail();
        $dates = explode(',', $request->dates);
        $shiftType = $request->shift_type === 'day' ? 'day_shift' : 'night_shift';

        foreach ($dates as $date) {
            $parsedDate = Carbon::createFromFormat('d-m-Y', trim($date));

            $shiftDetails = $rotation->getShiftBlocks($parsedDate, $parsedDate)->first();

            if (!$shiftDetails) {
                continue;
            }

            $shiftName = $shiftDetails[$shiftType] ?? null;

            if (!$shiftName) {
                continue; // Skip if shift name not found
            }


            $data = [
                'shift' => $shiftName,
                'shift_rotation_id' => $rotation->id,
                'start_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['start_date'])->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['end_date'])->format('Y-m-d'),
                'shift_type' => $request->shift_type,
                'date' => $parsedDate->format('Y-m-d'),
                'title' => $request->title,
                'description' => $request->description,
            ];

            // Handle file upload
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $fileName = time().'-site-communication'.'.'.$file->getClientOriginalExtension();
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

    public function show($id)
    {
        $siteCommunication = SiteCommunication::findOrFail($id);
        return view('admin.site-communication.show', compact('siteCommunication'));
    }

    public function edit($id)
    {
        $siteCommunication = SiteCommunication::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $siteCommunication
        ]);
    }

    public function update(SiteCommunicationRequest $request, $id)
    {
        $siteCommunication = SiteCommunication::findOrFail($id);
        $oldFilePath = $siteCommunication->path;

        // Delete the old record
        $siteCommunication->delete();

        $rotation = ShiftRotation::where('is_active', true)->firstOrFail();

        $dates = explode(',', $request->dates);
        $shiftType = $request->shift_type === 'day' ? 'day_shift' : 'night_shift';

        foreach ($dates as $date) {
            $parsedDate = Carbon::createFromFormat('d-m-Y', trim($date));

            $shiftDetails = $rotation->getShiftBlocks($parsedDate, $parsedDate)->first();

            // Skip if no shift details found
            if (!$shiftDetails) {
                continue;
            }

            $shiftName = $shiftDetails[$shiftType] ?? null;
            // Skip if shift name not found
            if (!$shiftName) {
                continue;
            }

            $data = [
                'shift' => $shiftName,
                'shift_rotation_id' => $rotation->id,
                'start_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['start_date'])->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['end_date'])->format('Y-m-d'),
                'shift_type' => $request->shift_type,
                'date' => $parsedDate->format('Y-m-d'),
                'title' => $request->title,
                'description' => $request->description,
                'path' => $oldFilePath
            ];

            // Handle new PDF upload
            if ($request->hasFile('pdf')) {
                if ($oldFilePath && file_exists(public_path('storage/'.$oldFilePath))) {
                    unlink(public_path('storage/'.$oldFilePath));
                }

                $file = $request->file('pdf');
                $fileName = time().'-site-communication.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $data['path'] = $filePath;
            }

            SiteCommunication::create($data);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Site Communication updated successfully'
        ]);
    }


    public function destroy($id)
    {
        $siteCommunication = SiteCommunication::findOrFail($id);

        if ($siteCommunication->path && file_exists(public_path('storage/'.$siteCommunication->path))) {
            unlink(public_path('storage/'.$siteCommunication->path));
        }

        $siteCommunication->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Site Communication deleted successfully'
        ]);
    }

    public function preview($path)
    {
        return response()->file(public_path('storage/uploads/'.$path));
    }
}
