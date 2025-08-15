<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\FatalityRisk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\FatalityRiskControlRequest;

class FatalityRiskControlController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FatalityRisk::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name ? $row->name : 'N/A';
                })
                ->editColumn('description', function ($row) {
                    return $row->description ? $row->description : 'N/A';
                })
                ->editColumn('image', function ($row) {
                    return $row->image ? '<img src="'.asset('storage/'.$row->image).'" width="50" height="50">' : '<img src="'.asset('assets/images/no-image.png').'" width="50" height="50">';
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
                ->rawColumns(['image', 'description', 'actions'])
                ->make(true);
        }
        return view('admin.fatality-risk-controls.index');
    }

    public function store(FatalityRiskControlRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/fatality-risk-controls', 'public');
        }

        FatalityRisk::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control created successfully.',
        ]);
    }

    public function edit($id)
    {
        $fatalityRiskControl = FatalityRisk::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $fatalityRiskControl,
        ]);
    }

    public function update(FatalityRiskControlRequest $request, $id)
    {
        $fatalityRiskControl = FatalityRisk::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($fatalityRiskControl->image && Storage::disk('public')->exists($fatalityRiskControl->image)) {
                Storage::disk('public')->delete($fatalityRiskControl->image);
            }

            $validated['image'] = $request->file('image')->store('images/fatality-risk-controls', 'public');
        } else {
            unset($validated['image']);
        }

        $fatalityRiskControl->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $fatalityRiskControl = FatalityRisk::findOrFail($id);

        if ($fatalityRiskControl->image && Storage::disk('public')->exists($fatalityRiskControl->image)) {
            Storage::disk('public')->delete($fatalityRiskControl->image);
        }

        $fatalityRiskControl->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control deleted successfully.',
        ]);
    }
}
