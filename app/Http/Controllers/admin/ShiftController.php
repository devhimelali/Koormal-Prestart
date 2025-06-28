<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shift::with('linkedShift');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('linked_shift', function ($row) {
                    return $row->linkedShift ? $row->linkedShift->name : 'N/A';
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
        return view('admin.shifts.index');
    }

    public function store(ShiftRequest $request)
    {
        Shift::create([
            'name' => $request->name,
            'linked_shift_id' => $request->linked_shift_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Shift created successfully'], 201);
    }

    public function edit($id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['status' => 'error', 'message' => 'Shift not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $shift], 200);
    }

    public function update(ShiftRequest $request, $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['status' => 'error', 'message' => 'Shift not found'], 404);
        }

        $shift->update([
            'name' => $request->name,
            'linked_shift_id' => $request->linked_shift_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Shift updated successfully'], 200);
    }

    public function destroy($id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['status' => 'error', 'message' => 'Shift not found'], 404);
        }

        $shift->delete();

        return response()->json(['status' => 'success', 'message' => 'Shift deleted successfully'], 200);
    }


    public function getShitList()
    {
        $shifts = Shift::get();
        return view('components.admin.shifts.linked-shift-option', compact('shifts'));
    }
}
