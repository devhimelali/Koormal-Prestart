@extends('layouts.app')
@section('title', 'Shift Rotations')
@section('content')
    <x-common.breadcrumb :title="'Shift Rotations'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Shift Rotations']]" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Shift Rotation Lists</h4>
                    <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center" id="addShiftRotationBtn">
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
                                    <th scope="col">Week</th>
                                    <th scope="col">Day Shift</th>
                                    <th scope="col">Night Shift</th>
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

    <x-common.dynamic-form-modal id="addOrEditShiftRotationModal" form-id="shiftRotationAddForm"
        title="Add a new shift rotation" submit-text="Save" />
    <x-common.delete-modal id="deleteShiftRotationModal" title="Delete Shift Rotation"
        message="Are you sure you want to delete this shift rotation?" />
@endsection
@include('components.admin.shift-rotations.vendor-script')
@include('components.admin.shift-rotations.vendor-css')
@include('components.admin.shift-rotations.page-script')
