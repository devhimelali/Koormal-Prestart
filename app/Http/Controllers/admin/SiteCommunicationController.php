<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
            $shiftType = $request->shift_type == 'day_shift' ? 'day' : 'night';
            $data = SiteCommunication::with('shift', 'shiftRotation')
                ->where('shift_type', $shiftType);

            $startDate = $request->start_date;
            $endDate = $request->end_date;

            if (isset($startDate) && isset($endDate)) {
                $data = $data->whereBetween('date', [$startDate, $endDate]);
            } else {
                $today = Carbon::today()->format('Y-m-d');
                $data = $data->where('date', $today);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('crew', function ($row) {
                    return $row->shift?->name;
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
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        View PDF
                                     </a>';
                        $buttons .= '<a href="'.$pdfUrl.'" target="_blank" class="btn btn-secondary btn-sm d-flex align-items-center gap-1">
                                        <i class="bi bi-download"></i>
                                        Download PDF
                                     </a>';
                    }
                    $buttons .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-warning btn-sm d-flex align-items-center gap-1">
                                    <i class="bi bi-pencil"></i>
                                    Edit
                                  </a>';
                    $buttons .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                  </a>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'pdf' => ['nullable', 'file', 'mimes:pdf'],
            'shift_type' => ['required', Rule::in(['day', 'night'])]
        ]);

        $siteCommunication = SiteCommunication::findOrFail($id);

        $data = [
            'shift_type' => $request->shift_type,
            'date' => Carbon::createFromFormat('d-m-Y', $request->dates)->format('Y-m-d'),
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('pdf')) {
            if ($siteCommunication->path && file_exists(public_path('storage/'.$siteCommunication->path))) {
                unlink(public_path('storage/'.$siteCommunication->path));
            }

            $file = $request->file('pdf');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $data['path'] = $filePath;
        }

        $siteCommunication->update($data);

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
}
