<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrossCriteriaRequest;
use App\Models\CrossCriteria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CrossCriteriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CrossCriteria::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($row) {
                    return $row->description;
                })
                ->editColumn('color', function ($row) {
                    return '<span class="badge" style="background-color: ' . e($row->color) . '; padding: 4px 8px; border-radius: 5px;">' . e($row->color) . '</span>';
                })
                ->addColumn(
                    'actions',
                    function ($row) {
                        return '<div class="btn-group">
                                <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-secondary btn-sm d-flex align-items-center">
                                    <i class="ph ph-pencil me-1"></i>
                                    Edit
                                </a>
                                <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm d-flex align-items-center">
                                    <i class="ph ph-trash me-1"></i>
                                    Delete
                                </a>
                            </div>';
                    }
                )
                ->rawColumns(['color', 'description', 'actions'])
                ->make(true);
        }
        return view('admin.cross_criteria.index');
    }

    public function store(CrossCriteriaRequest $request)
    {
        $validated = $request->validated();
        $validated['bg_color'] = $this->hexToRgbaBlade($validated['color'], 0.3);
        CrossCriteria::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Cross Criteria created successfully'
        ], 201);
    }

    public function edit($id)
    {
        $cross_criteria = CrossCriteria::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $cross_criteria
        ]);
    }

    public function update(CrossCriteriaRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['bg_color'] = $this->hexToRgbaBlade($validated['color'], 0.3);
        $cross_criteria = CrossCriteria::findOrFail($id);
        $cross_criteria->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Cross Criteria updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $cross_criteria = CrossCriteria::findOrFail($id);
        $cross_criteria->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cross Criteria deleted successfully'
        ]);
    }

    private function hexToRgbaBlade($hex, $opacity)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba($r, $g, $b, $opacity)";
    }
}
