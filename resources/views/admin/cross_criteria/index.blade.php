@extends('layouts.app')
@section('title', 'Cross Criteria')
@section('content')
    <x-common.breadcrumb :title="'Cross Criteria'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Cross Criteria']]" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Cross Criteria List</h3>
                    <div>
                        <button class="btn btn-sm btn-secondary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addOrEditModal">
                            <i class="ph ph-plus me-1"></i>
                            Add
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <x-table id="dataTable" tableVariant="table-sm table-hover table-striped align-middle mb-0"
                        :thead="[
                            [
                                'label' => '#',
                                'class' => 'th-sn',
                            ],
                            [
                                'label' => 'name',
                                'class' => 'th-name',
                            ],
                            [
                                'label' => 'Color Code',
                                'class' => 'th-color-code',
                            ],
                            [
                                'label' => 'Description',
                                'class' => 'th-description',
                            ],
                            [
                                'label' => 'Actions',
                                'class' => 'th-actions',
                            ],
                        ]" />
                </div>
            </div>
        </div>
    </div>
    <style>
        .th-sn {
            max-width: 50px;
            width: 50px;
        }

        .th-color-code {
            max-width: 120px;
            width: 120px;
        }

        .th-actions {
            min-width: 100px;
            width: 100px;
        }

        @media only screen and (max-width: 480px) {
            .th-name {
                min-width: 150px;
                width: 150px;
            }

            .th-color-code {
                min-width: 100px;
            }

            .th-description {
                min-width: 250px;
                width: 250px;
            }

            .th-actions {
                min-width: 100px;
                width: 100px;
            }
        }
    </style>
    <!-- Add or Edit Modal -->
    @include('components.admin.cross-criteria.modal.add-or-edit')
    <!-- Delete Modal -->
    <x-common.delete-modal id="deleteCrossCriteriaModal" title="Delete Cross Criteria"
        message="Are you sure you want to delete this cross criteria?" />
@endsection
@include('components.admin.cross-criteria.vendor-script')
@include('components.admin.cross-criteria.vendor-css')
@include('components.admin.cross-criteria.page-script')
