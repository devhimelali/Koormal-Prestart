<?php

namespace App\Http\Controllers;

use App\Http\Requests\FatalityRiskControlRequest;
use App\Http\Requests\FatalityRiskRequest;
use App\Models\FatalityRisk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class FatalityRiskController extends Controller
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

        return view('admin.fatality-risks.index');
    }

    public function store(FatalityRiskRequest $request)
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

    public function edit(FatalityRisk $fatalityRisk)
    {
        return response()->json([
            'status' => 'success',
            'data' => $fatalityRisk,
        ]);
    }

    public function update(FatalityRiskRequest $request, FatalityRisk $fatalityRisk)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($fatalityRisk->image && Storage::disk('public')->exists($fatalityRisk->image)) {
                Storage::disk('public')->delete($fatalityRisk->image);
            }

            $validated['image'] = $request->file('image')->store('images/fatality-risk-controls', 'public');
        } else {
            unset($validated['image']);
        }

        $fatalityRisk->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control updated successfully.',
        ]);
    }

    public function destroy(FatalityRisk $fatalityRisk)
    {
        if ($fatalityRisk->image && Storage::disk('public')->exists($fatalityRisk->image)) {
            Storage::disk('public')->delete($fatalityRisk->image);
        }

        $fatalityRisk->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fatality Risk Control deleted successfully.',
        ]);
    }
}
