@extends('layouts.app')
@section('title', 'Boards History')
@section('content')
    <x-common.breadcrumb :title="'Boards History'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Boards History']]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="background-color: #fff; padding: 1rem">
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
    <div id="board-wrapper"></div>
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

            $.ajax({
                url: "{{route('boards.get-board-history-list')}}",
                type: "GET",
                data: {
                    date_range: date_range,
                    board: board,
                    crew: crew,
                    shift: shift,
                },
                beforeSend: function () {
                    $('#board-wrapper').html('');
                    $('#loader').show();
                },
                success: function (response) {
                    $('#board-wrapper').html(response);
                },
                error: function (xhr, error, status) {
                    console.log(xhr, error, status);
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        })
    </script>
@endsection
@section('page-css')
    <style>
        .supervisor-name {
            border: 1px solid #ccc;
            padding: 4px 8px;
            min-width: 250px;
            width: 250px;
            border-radius: 4px;
            background-color: #f9f9f9;
            text-align: left;
        }

        .card-header {
            background-color: #0d0172;
            border-bottom: 1px solid #060041;
            color: #fff;
            padding: 0.8rem 1rem;
        }

        .card-title {
            font-size: 1.45rem;
            font-weight: 600;
        }

        .card-body {
            background-color: #00680e;
            padding: 0.5rem;
            border-radius: 0% 0% 4px 4px;
        }

        .board-container {
            background-color: #fff;
            border-radius: 6px;
            padding: 1rem;
        }

        .board {
            border: 2px solid #00680e;
            border-radius: 6px;
            padding: 1.5rem;
            background-color: #fff;
        }

        .board-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .header-logo {
            max-width: 90px;
        }

        .table > :not(caption) > * > * {
            padding: .45rem .5rem;
        }

        span.play-icon {
            background-color: #007bff;
            color: #fff;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-align: center;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        span.play-icon.active {
            background-color: #28a745;
            transform: scale(1.1);
        }

        span.play-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        i.ph {
            font-size: 16px;
        }

        .td-date {
            min-width: 100px !important;
            max-width: 180px;
            width: 180px;
        }

        @media only screen and (max-width: 768px) {
            .board-title {
                font-size: 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 0;
            }

            .btn-sm {
                margin-top: 0.5rem;
            }

            .board-header img {
                max-width: 70px;
            }
        }

        @media only screen and (max-width: 480px) {

            .board {
                padding: 1.5rem .6rem;
            }

            .supervisor-name {
                font-size: 16px;
                padding: 6px 10px;
                min-width: 170px;
                width: 170px;
            }

            .supervisor-name-title {
                font-size: 16px;
            }

            .card-body {
                padding: 0;
            }

            .board-header img {
                max-width: 50px;
            }

            .board-title {
                font-size: 0.9rem;
            }

            .board-container {
                border-radius: 3px;
                padding: 0.5rem;
            }

            .td-date {
                min-width: 95px !important;
                max-width: 95px;
                width: 95px !important;
                overflow-wrap: break-word;
                word-break: break-word;
                white-space: normal;
            }
        }
    </style>
@endsection
