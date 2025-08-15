<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FatalityControlRequest;
use App\Models\FatalityControl;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FatalityControlController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FatalityControl::with('fatalityRisk');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->fatalityRisk ? $row->fatalityRisk->name : 'N/A';
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('fatalityRisk', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%'.$keyword.'%');
                    });
                })
                ->editColumn('description', function ($row) {
                    return $row->description ? $row->description : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                                <button class="btn btn-secondary btn-sm edit d-flex align-items-center gap-1" data-id="'.$row->id.'">
                                <i class="bi bi-pencil"></i>
                                Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete d-flex align-items-center gap-1" data-id="'.$row->id.'">
                                <i class="bi bi-trash"></i>
                                Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['description', 'actions'])
                ->make(true);
        }
        return view('admin.fatality-controls.index');
    }

    public function store(FatalityControlRequest $request)
    {
        $validated = $request->validated();

        FatalityControl::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Control created successfully.',
        ]);
    }

    public function edit(FatalityControl $fatalityControl)
    {
        return response()->json([
            'status' => 'success',
            'data' => $fatalityControl,
        ]);
    }

    public function update(FatalityControlRequest $request, FatalityControl $fatalityControl)
    {
        $validated = $request->validated();

        $fatalityControl->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Control updated successfully.',
        ]);
    }

    public function destroy(FatalityControl $fatalityControl)
    {
        $fatalityControl->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Control deleted successfully.',
        ]);
    }
}
