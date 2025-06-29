<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRotationRequest;
use App\Models\Shift;
use App\Models\ShiftRotation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftRotationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ShiftRotation::with(['dayShift', 'nightShift']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('week_index', function ($row) {
                    return 'Week ' . ($row->week_index + 1);
                })
                ->editColumn('day_shift', function ($row) {
                    return $row->dayShift ? $row->dayShift->name : 'N/A';
                })
                ->editColumn('night_shift', function ($row) {
                    return $row->nightShift ? $row->nightShift->name : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-secondary btn-sm d-flex align-items-center">
                                    <i class="ph ph-pencil me-1"></i>
                                    Edit
                              </a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm d-flex align-items-center">
                                    <i class="ph ph-trash me-1"></i>
                                    Delete
                              </a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $dayShifts = Shift::get();
        $nightShifts = Shift::get();

        return view('admin.shift-rotations.index', compact('dayShifts', 'nightShifts'));
    }

    public function store(ShiftRotationRequest $request)
    {
        ShiftRotation::create([
            'week_index' => $request->week_index,
            'day_shift_id' => $request->day_shift_id,
            'night_shift_id' => $request->night_shift_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Shift rotation created successfully'
        ], 201);
    }

    public function edit($id)
    {
        $shiftRotation = ShiftRotation::findOrFail($id);

        if (!$shiftRotation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shift rotation not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $shiftRotation
        ]);
    }

    public function update(ShiftRotationRequest $request, $id)
    {
        $shiftRotation = ShiftRotation::findOrFail($id);

        if (!$shiftRotation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shift rotation not found'
            ], 404);
        }

        $shiftRotation->update([
            'week_index' => $request->week_index,
            'day_shift_id' => $request->day_shift_id,
            'night_shift_id' => $request->night_shift_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Shift rotation updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $shiftRotation = ShiftRotation::find($id);

        if (!$shiftRotation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shift rotation not found'
            ], 404);
        }

        $shiftRotation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Shift rotation deleted successfully'
        ]);
    }
}
