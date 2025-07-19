@extends('layouts.app')
@section('title', 'Boards')
@section('content')
    @php
        // $start_date = request('start_date');
        // $end_date = request('end_date');
        // $crew = request('crew');
        // $shift = request('shift');
        // function dateRangeBetween($startDate, $endDate)
        // {
        //     $dates = [];
        //     $currentDate = \Carbon\Carbon::parse($startDate);
        //     while ($currentDate->lte($endDate)) {
        //         $dates[] = $currentDate->format('d-m-Y');
        //         $currentDate->addDay();
        //     }
        //     return $dates;
        // }
        // $dateArrayBetween = dateRangeBetween($start_date, $end_date);
    @endphp
    <x-common.breadcrumb :title="'Boards'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards']]" />
    <div class="row">
        <div class="col-12 mx-auto bg-white p-3 mb-4 border rounded shadow-sm text-center">
            <h4 class="mb-1 d-flex align-items-center justify-content-center gap-2">
                <span class="supervisor-name-title">Supervisor Name:</span>
                <span contenteditable="true" class="d-inline-block supervisor-name">
                    {{ $dailyShiftEntry->supervisor_name ?? '' }}
                </span>
            </h4>
            <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $startDate }} to
                {{ $endDate }}
            </p>
            <p class="mb-0 text-secondary" style="font-size: 16px;"> <strong>Shift: </strong>
                {{ ucfirst($shiftType) }}
            </p>
            <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crewName) }}
            </p>
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
