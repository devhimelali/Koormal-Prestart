@extends('layouts.app')
@section('title', 'Rotation Settings')
@section('content')
    <x-common.breadcrumb :title="'Rotation Settings'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Rotation Settings']]" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Rotation Setting Lists</h4>
                    <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center"
                        id="addRotationSettingBtn">
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
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Rotation Days</th>
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

    <x-common.dynamic-form-modal id="addOrEditRotationSettingModal" form-id="rotationSettingAddForm"
        title="Add a new rotation setting" submit-text="Save" />
    <x-common.delete-modal id="deleteRotationSettingModal" title="Delete Rotation Setting"
        message="Are you sure you want to delete this rotation setting?" />
@endsection
@include('components.admin.rotation-settings.vendor-script')
@include('components.admin.rotation-settings.vendor-css')
@include('components.admin.rotation-settings.page-script')
