@extends('layouts.app')
@section('title', 'Boards History')
@section('content')
    <x-common.breadcrumb :title="'Boards History'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards History']]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="date-range" class="form-label">
                                Select Date Range
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="date_range" class="form-control" id="date-range">
                        </div>
                        <div class="col-md-3">
                            <label for="board" class="form-label">
                                Board
                                <span class="text-danger">*</span>
                            </label>
                            <select name="board" id="board" class="form-select">
                                <option value="">Select Board</option>
                                @foreach($boards as $key => $board)
                                    <option value="{{ $key }}">{{ $board }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="crew" class="form-label">
                                Crew
                                <span class="text-danger">*</span>
                            </label>
                            <select name="crew" id="crew" class="form-select">
                                <option value="">Select Crew</option>
                                @forelse($crews as $crew)
                                    <option value="{{ $crew->name }}">{{ $crew->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="shift" class="form-label">
                                Shift
                                <span class="text-danger">*</span>
                            </label>
                            <select name="shift" id="shift" class="form-select">
                                <option value="">Select Shift</option>
                                <option value="day">Day Shift</option>
                                <option value="night">Night Shift</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button
                                id="searchBoardBtn"
                                class="btn btn-secondary d-flex align-items-center justify-content-center gap-2 w-100 mt-md-4">
                                <i class="ph ph-magnifying-glass"></i>
                                Search Board
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y"
        })

        $('#searchBoardBtn').on('click', function () {
            let date_range = $('#date-range').val();
            let board = $('#board').val();
            let crew = $('#crew').val();
            let shift = $('#shift').val();

            // Example: log the values
            console.log({
                date_range,
                board,
                crew,
                shift
            });
        })
    </script>
@endsection
