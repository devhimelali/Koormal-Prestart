@extends('layouts.app')
@section('title', 'Shifts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Shifts</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('redirect') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shifts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Shift Lists</h4>
                    <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center" id="addShiftBtn">
                        <i class="ph ph-plus me-1"></i>
                        Add New
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered align-middle mb-0" id="dataTable">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" style="max-width: 50px; width: 50px;">S.No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Linked Shift</th>
                                    <th scope="col" style="max-width: 180px; width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin.shifts.add-or-edit-modal')
    @include('components.admin.shifts.delete-modal')
@endsection
@include('components.admin.shifts.vendor-script')
@include('components.admin.shifts.vendor-css')
@include('components.admin.shifts.page-script')
@include('components.admin.shifts.page-css')
