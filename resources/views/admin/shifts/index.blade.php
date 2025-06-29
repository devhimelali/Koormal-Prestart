@extends('layouts.app')
@section('title', 'Shifts')
@section('content')
    <x-common.breadcrumb :title="'Shifts'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Shifts']]" />

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
    <x-common.delete-modal id="deleteShiftModal" title="Delete Shift"
        message="Are you sure you want to delete this shift?" />
@endsection
@include('components.admin.shifts.vendor-script')
@include('components.admin.shifts.vendor-css')
@include('components.admin.shifts.page-script')
@include('components.admin.shifts.page-css')
