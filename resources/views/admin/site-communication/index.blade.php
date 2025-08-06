@extends('layouts.app')
@section('title', 'Site Communications')
@section('content')
    <x-common.breadcrumb :title="'Site Communications'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Site Communications']]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Site Communications</h4>
                    <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#addSiteCommunication">
                        <i class="ph ph-plus"></i>
                        Add Site Communication
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin.site-communication.modals.add-site-communication')
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#dates", {
            mode: "multiple",
            dateFormat: "d-m-Y",
        });
    </script>
@endsection
@section('page-css')
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">--}}
@endsection
