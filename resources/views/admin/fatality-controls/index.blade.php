@extends('layouts.app')
@section('title', 'Fatality Controls')
@section('content')
    <x-common.breadcrumb
        :title="'Fatality Controls'"
        :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Fatality Controls']]
    "/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Fatality Control List</h3>
                    <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#addFatalityControlModal">
                        <i class="ph ph-plus"></i>
                        Add New Fatality Control
                    </button>
                </div>
                <div class="card-body">
                    <x-table id="fatalityControlsTable"
                             tableVariant="table-sm table-hover table-striped align-middle mb-0" :thead="[
                            [
                                'label' => '#',
                                'class' => 'th-sn',
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

    @include('components.admin.fatality-controls.modals.add-or-edit')
    <!-- Delete Modal -->
    <x-common.delete-modal id="deleteFatalityRiskModal" title="Delete Fatality Control"
                           message="Are you sure you want to delete this fatality control?"/>
@endsection
