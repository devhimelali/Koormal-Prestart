@extends('layouts.app')
@section('title', 'Shifts')
@section('content')
    <x-common.breadcrumb :title="'Shifts'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Shifts']]"/>

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
                    <x-table id="dataTable" :thead="[
                        [
                            'label' => '#',
                            'class' => 'th-sn',
                        ],
                        [
                            'label' => 'Name',
                        ],
                        [
                            'label' => 'Linked Shift',
                        ],
                        [
                            'label' => 'Actions',
                            'class' => 'th-actions',
                        ],
                    ]"/>
                </div>
            </div>
        </div>
    </div>
    <style>
        .th-sn {
            max-width: 50px;
            width: 50px;
        }

        .th-actions {
            max-width: 130px;
            width: 130px;
        }

        @media only screen and (max-width: 767px) {

            .th-name,
            .th-linked-shift {
                min-width: 100px;
            }
        }
    </style>
    {{-- <x-common.dynamic-form-modal id="addOrEditShiftModal" form-id="shiftAddForm" title="Add a new shift"
        submit-text="Save" /> --}}
    @include('components.admin.shifts.modal.add-or-edit')
    <x-common.delete-modal id="deleteShiftModal" title="Delete Shift"
                           message="Are you sure you want to delete this shift?"/>
@endsection
@include('components.admin.shifts.vendor-script')
@include('components.admin.shifts.vendor-css')
@include('components.admin.shifts.page-script')
