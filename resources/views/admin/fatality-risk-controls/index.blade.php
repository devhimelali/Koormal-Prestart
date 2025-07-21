@extends('layouts.app')
@section('title', 'Fatality Risk Controls')
@section('content')
    <x-common.breadcrumb :title="'Fatality Risk Controls'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Fatality Risk Controls']]" />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Fatality Risk Control List</h3>
                    <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                        data-bs-target="#addFatalityRiskControlModal">
                        <i class="ph ph-plus"></i>
                        Add New Fatality Risk Control
                    </button>
                </div>
                <div class="card-body">
                    <x-table id="fatalityRiskControlsTable" :thead="[
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
                        ],
                        [
                            'label' => 'Description',
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
    @include('components.admin.fatality-risk-controls.modals.add-or-edit')
@endsection
@include('components.admin.fatality-risk-controls.vendor-css')
@include('components.admin.fatality-risk-controls.vendor-script')
@include('components.admin.fatality-risk-controls.page-scripts')
@include('components.admin.fatality-risk-controls.page-css')
