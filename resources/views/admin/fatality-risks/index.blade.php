@extends('layouts.app')
@section('title', 'Fatality Risks')
@section('content')
    <x-common.breadcrumb
        :title="'Fatality Risks'"
        :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Fatality Risks']]
    "/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Fatality Risk List</h3>
                    <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#addFatalityRiskModal">
                        <i class="ph ph-plus"></i>
                        Add New Fatality Risk
                    </button>
                </div>
                <div class="card-body">
                    <x-table id="fatalityRisksTable"
                             tableVariant="table-sm table-hover table-striped align-middle mb-0" :thead="[
                            [
                                'label' => '#',
                                'class' => 'th-sn',
                            ],
                            [
                                'label' => 'Image',
                                'class' => 'th-image',
                            ],
                            [
                                'label' => 'Name',
                                'class' => 'th-name',
                            ],
                            [
                                'label' => 'Description',
                                'class' => 'th-description',
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

    @include('components.admin.fatality-risks.modals.add-or-edit')
    <!-- Delete Modal -->
    <x-common.delete-modal id="deleteFatalityRiskModal" title="Delete Fatality Risk"
                           message="Are you sure you want to delete this fatality risk?"/>
@endsection
@include('components.admin.fatality-risks.vendor-css')
@include('components.admin.fatality-risks.vendor-script')
@include('components.admin.fatality-risks.page-scripts')
@include('components.admin.fatality-risks.page-css')
