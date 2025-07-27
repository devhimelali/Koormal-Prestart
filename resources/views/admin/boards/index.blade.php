@extends('layouts.app')
@section('title', 'Boards')
@section('content')
    <x-common.breadcrumb :title="'Boards'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards']]"/>
    <div class="row">
        <div class="col-12 mx-auto bg-white p-3 border mb-3 rounded shadow-sm text-center" id="board-header">
            <h4 class="mb-1 d-flex align-items-center justify-content-center gap-2">
                <span class="supervisor-name-title">Supervisor Name:</span>
                <span contenteditable="true" class="d-inline-block supervisor-name">
                    {{ $dailyShiftEntry->supervisor_name ?? '' }}
                </span>
            </h4>
            <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $startDate }} to
                {{ $endDate }}
            </p>
            <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Shift: </strong>
                {{ ucfirst($shiftType) }}
            </p>
            <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crewName) }}
            </p>
        </div>
        <div class="d-flex justify-content-between align-items-center  bg-white p-3 rounded shadow-sm mb-4 d-none"
             id="board-info">

        </div>
    </div>

    <div class="col-12">
        <div class="card shadow">
            <div class="card-header text-center">
                <h4 class="card-title mb-0" id="board-title">Our Health & Safety</h4>
            </div>
            <div class="card-body">
                <div class="board-container" id="board-container">

                </div>
            </div>
        </div>
    </div>
    @include('components.admin.boards.modal.cross-criteria-view')
@endsection
@include('components.admin.boards.page-css')
@include('components.admin.boards.page-script')
