@extends('layouts.app')
@section('title', 'Boards')
@section('content')
    @php
        $start_date = request()->query('start_date');
        $end_date = request()->query('end_date');
        $shift_type = request()->query('shift_type');
        $crew = request()->query('crew');
        $shift_id = \App\Models\Shift::where('name', $crew)->first()->id;
//        dd($shift_id);
        $rotation_id = \App\Models\ShiftRotation::where('is_active', true)->value('id');
    @endphp
    <x-common.breadcrumb :title="'Boards'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards']]"/>

    <div class="card">
        <div class="card-body" style="background: #fff">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="card name-card border border-2 border-success mb-0">
                        <div class="name-card-body">
                            <h5 class="mb-1 text-center">Supervisor Name :</h5>
                            <p class="text-muted mb-0 text-center">{{ $supervisor?->name ?? 'N/A' }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 mx-auto bg-white p-3 border mb-3 rounded shadow-sm text-center" id="board-header">
                    <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $start_date }} to
                        {{ $end_date }}
                    </p>
                    <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Shift: </strong>
                        {{ ucfirst($shift_type) }}
                    </p>
                    <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crew) }}
                    </p>
                </div>
                <div class="col-md-5">
                    <div class="card name-card border border-2 border-success mb-0 ms-auto">
                        <div class="name-card-body">
                            <h5 class="mb-1 text-center">Labour Name :</h5>
                            <p class="text-muted mb-0 text-center">{{ $labor->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <style>
                    .name-card-body {
                        padding: 0.5rem;
                        border-radius: 0% 0% 4px 4px;
                    }

                    .name-card {
                        min-width: 350px;
                        max-width: 450px;
                    }
                </style>
            </div>
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
