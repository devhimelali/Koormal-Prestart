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
        $this->processSiteCommunications($request);

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

        // Process new records
        $this->processSiteCommunications($request, $oldFilePath);

        // Delete the old file if the new file was uploaded
        if ($request->hasFile('pdf') && $oldFilePath) {
            $this->deleteFileIfExists($oldFilePath);
        }

        // Delete the old record
        $siteCommunication->delete();

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

    /**
     * Process site communication records for multiple dates and shift types
     */
    private function processSiteCommunications(SiteCommunicationRequest $request, ?string $existingFilePath = null)
    {
        $rotation = ShiftRotation::where('is_active', true)->firstOrFail();
        $dates = explode(',', $request->dates);

        // Determine which shift types to process
        $shiftTypesToProcess = [];

        if ($request->shift_type === 'both') {
            $shiftTypesToProcess = ['day', 'night'];
        } else {
            $shiftTypesToProcess = [$request->shift_type];
        }

        $filePath = $existingFilePath;
        $createdRecords = [];

        foreach ($dates as $date) {
            $parsedDate = Carbon::createFromFormat('d-m-Y', trim($date));
            $shiftDetails = $rotation->getShiftBlocks($parsedDate, $parsedDate)->first();

            if (!$shiftDetails) {
                continue;
            }

            foreach ($shiftTypesToProcess as $shiftType) {
                $shiftField = $shiftType === 'day' ? 'day_shift' : 'night_shift';
                $shiftName = $shiftDetails[$shiftField] ?? null;

                if (!$shiftName) {
                    continue;
                }

                $data = [
                    'shift' => $shiftName,
                    'shift_rotation_id' => $rotation->id,
                    'start_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['start_date'])->format('Y-m-d'),
                    'end_date' => Carbon::createFromFormat('d-m-Y', $shiftDetails['end_date'])->format('Y-m-d'),
                    'shift_type' => $shiftType,
                    'date' => $parsedDate->format('Y-m-d'),
                    'title' => $request->title,
                    'description' => $request->description,
                    'path' => $filePath
                ];

                // Handle file upload - only upload once
                if ($request->hasFile('pdf')) {
                    if (!$filePath) {
                        $file = $request->file('pdf');
                        $fileName = time().'-site-communication'.'.'.$file->getClientOriginalExtension();
                        $filePath = $file->storeAs('uploads', $fileName, 'public');
                        $data['path'] = $filePath;
                    }
                }

                $createdRecords[] = SiteCommunication::create($data);
            }
        }

        return $createdRecords;
    }


    /**
     * Handle file deletion if needed
     */
    private function deleteFileIfExists(?string $filePath): void
    {
        if ($filePath && file_exists(public_path('storage/'.$filePath))) {
            unlink(public_path('storage/'.$filePath));
        }
    }
}
