<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RotationSettingRequest;
use App\Models\RotationSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RotationSettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RotationSetting::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $btns = '<div class="btn-group">';
                    $btns .= '<button class="btn btn-sm btn-secondary edit d-flex align-items-center" data-id="' . $row->id . '" >
                                <i class="ph ph-pencil me-1"></i>
                                Edit
                            </button>';
                    $btns .= '<button class="btn btn-sm btn-danger delete d-flex align-items-center" data-id="' . $row->id . '" >
                                <i class="ph ph-trash me-1"></i>
                                Delete
                            </button>';
                    $btns .= '</div>';
                    return $btns;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.rotation_settings.index');
    }

    public function store(RotationSettingRequest $request)
    {
        RotationSetting::create([
            'start_date' => $request->start_date,
            'rotation_days' => $request->rotation_days,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rotation setting saved successfully.'
        ], 201);
    }

    public function edit($id)
    {
        $rotationSetting = RotationSetting::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $rotationSetting
        ]);
    }

    public function update(RotationSettingRequest $request, $id)
    {
        $rotationSetting = RotationSetting::find($id);
        $rotationSetting->update([
            'start_date' => $request->start_date,
            'rotation_days' => $request->rotation_days,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rotation setting updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $rotationSetting = RotationSetting::find($id);
        $rotationSetting->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rotation setting deleted successfully.'
        ]);
    }
}
