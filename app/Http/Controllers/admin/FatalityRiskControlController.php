<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\FatalityRiskControl;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FatalityRiskControlController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FatalityRiskControl::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return $row->name ? $row->name : 'N/A';
                })
                ->editColumn('description', function ($row) {
                    return $row->description ? substr($row->description, 0, 50) . '...' : 'N/A';
                })
                ->editColumn('image', function ($row) {
                    return $row->image ? '<img src="' . asset($row->image) . '" width="50" height="50">' : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $row->id . '">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>
                            </div>';
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }
        return view('admin.fatality-risk-controls.index');
    }
}
