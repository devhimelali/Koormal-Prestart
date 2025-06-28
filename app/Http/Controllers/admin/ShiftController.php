<?php

namespace App\Http\Controllers\admin;

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
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-secondary btn-sm">
                                    <i class="bi bi-pencil me-2"></i>
                                    Edit
                              </a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">
                                    <i class="bi bi-trash me-2"></i>
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
}
