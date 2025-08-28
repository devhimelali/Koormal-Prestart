<div class="card">
    <div class="card-body" style="background: #fff">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Supervisor Name :</h5>
                        <p class="text-muted mb-0 text-center">{{ $supervisor ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-auto bg-white p-3 border mb-3 rounded shadow-sm text-center" id="board-header">
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $start_date }} to
                    {{ $end_date }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Shift: </strong>
                    {{ ucfirst($shift_type) }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crew) }}
                </p>
            </div>
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0 ms-auto">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Labour Name :</h5>
                        <p class="text-muted mb-0 text-center" id="labour-name">{{ $labour ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <style>
                .name-card-body {
                    padding: 0.5rem;
                    border-radius: 0% 0% 4px 4px;
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
            <div class="board-container">


                <div class="board">
                    <!-- Header with Logos and Title -->
                    <div class="row align-items-center board-header mb-3">
                        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
                            <img src="{{ asset('assets/logos/4emus-logo.png') }}"
                                 class="img-fluid header-logo float-start">
                        </div>
                        <div class="col-8 col-md-8 text-center">
                            <h5 class="board-title mb-0">What is our assessment of our <br/>
                                <span style="color: #202a44;">Health & Safety performance during the last shift?</span>
                            </h5>
                        </div>
                        <div class="col-2 col-md-2 text-end text-md-center">
                            <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                 class="img-fluid header-logo float-end">
                        </div>
                    </div>

                    <div class="safety-calendar-board my-4">
                        <div class="calendar">
                            <!-- Row 1: 2 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_1 = $healthSafetyCrossCriteria->where('cell_number', 1)->first();
                                    $cell_2 = $healthSafetyCrossCriteria->where('cell_number', 2)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="1"
                                     style="background-color: {{ $cell_1?->criteria_bg_color }}; border: {{ $cell_1?->criteria_color }} 2px solid;">
                                    1
                                </div>
                                <div class="calendar-cell" data-cell="2"
                                     style="background-color: {{ $cell_2?->criteria_bg_color }}; border: {{ $cell_2?->criteria_color }} 2px solid;">
                                    2
                                </div>
                            </div>

                            <!-- Row 2: 3 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_3 = $healthSafetyCrossCriteria->where('cell_number', 3)->first();
                                    $cell_4 = $healthSafetyCrossCriteria->where('cell_number', 4)->first();
                                    $cell_5 = $healthSafetyCrossCriteria->where('cell_number', 5)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="3"
                                     style="background-color: {{ $cell_3?->criteria_bg_color }}; border: {{ $cell_3?->criteria_color }} 2px solid;">
                                    3
                                </div>
                                <div class="calendar-cell" data-cell="4"
                                     style="background-color: {{ $cell_4?->criteria_bg_color }}; border: {{ $cell_4?->criteria_color }} 2px solid;">
                                    4
                                </div>
                                <div class="calendar-cell" data-cell="5"
                                     style="background-color: {{ $cell_5?->criteria_bg_color }}; border: {{ $cell_5?->criteria_color }} 2px solid;">
                                    5
                                </div>
                            </div>

                            <!-- Row 3: 7 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_6 = $healthSafetyCrossCriteria->where('cell_number', 6)->first();
                                    $cell_7 = $healthSafetyCrossCriteria->where('cell_number', 7)->first();
                                    $cell_8 = $healthSafetyCrossCriteria->where('cell_number', 8)->first();
                                    $cell_9 = $healthSafetyCrossCriteria->where('cell_number', 9)->first();
                                    $cell_10 = $healthSafetyCrossCriteria->where('cell_number', 10)->first();
                                    $cell_11 = $healthSafetyCrossCriteria->where('cell_number', 11)->first();
                                    $cell_12 = $healthSafetyCrossCriteria->where('cell_number', 12)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="6"
                                     style="background-color: {{ $cell_6?->criteria_bg_color }}; border: {{ $cell_6?->criteria_color }} 2px solid;">
                                    6
                                </div>
                                <div class="calendar-cell" data-cell="7"
                                     style="background-color: {{ $cell_7?->criteria_bg_color }}; border: {{ $cell_7?->criteria_color }} 2px solid;">
                                    7
                                </div>
                                <div class="calendar-cell" data-cell="8"
                                     style="background-color: {{ $cell_8?->criteria_bg_color }}; border: {{ $cell_8?->criteria_color }} 2px solid;">
                                    8
                                </div>
                                <div class="calendar-cell" data-cell="9"
                                     style="background-color: {{ $cell_9?->criteria_bg_color }}; border: {{ $cell_9?->criteria_color }} 2px solid;">
                                    9
                                </div>
                                <div class="calendar-cell" data-cell="10"
                                     style="background-color: {{ $cell_10?->criteria_bg_color }}; border: {{ $cell_10?->criteria_color }} 2px solid;">
                                    10
                                </div>
                                <div class="calendar-cell" data-cell="11"
                                     style="background-color: {{ $cell_11?->criteria_bg_color }}; border: {{ $cell_11?->criteria_color }} 2px solid;">
                                    11
                                </div>
                                <div class="calendar-cell" data-cell="12"
                                     style="background-color: {{ $cell_12?->criteria_bg_color }}; border: {{ $cell_12?->criteria_color }} 2px solid;">
                                    12
                                </div>
                            </div>

                            <!-- Row 4: 7 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_13 = $healthSafetyCrossCriteria->where('cell_number', 13)->first();
                                    $cell_14 = $healthSafetyCrossCriteria->where('cell_number', 14)->first();
                                    $cell_15 = $healthSafetyCrossCriteria->where('cell_number', 15)->first();
                                    $cell_16 = $healthSafetyCrossCriteria->where('cell_number', 16)->first();
                                    $cell_17 = $healthSafetyCrossCriteria->where('cell_number', 17)->first();
                                    $cell_18 = $healthSafetyCrossCriteria->where('cell_number', 18)->first();
                                    $cell_19 = $healthSafetyCrossCriteria->where('cell_number', 19)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="13"
                                     style="background-color: {{ $cell_13?->criteria_bg_color }}; border: {{ $cell_13?->criteria_color }} 2px solid;">
                                    13
                                </div>
                                <div class="calendar-cell" data-cell="14"
                                     style="background-color: {{ $cell_14?->criteria_bg_color }}; border: {{ $cell_14?->criteria_color }} 2px solid;">
                                    14
                                </div>
                                <div class="calendar-cell" data-cell="15"
                                     style="background-color: {{ $cell_15?->criteria_bg_color }}; border: {{ $cell_15?->criteria_color }} 2px solid;">
                                    15
                                </div>
                                <div class="calendar-cell" data-cell="16"
                                     style="background-color: {{ $cell_16?->criteria_bg_color }}; border: {{ $cell_16?->criteria_color }} 2px solid;">
                                    16
                                </div>
                                <div class="calendar-cell" data-cell="17"
                                     style="background-color: {{ $cell_17?->criteria_bg_color }}; border: {{ $cell_17?->criteria_color }} 2px solid;">
                                    17
                                </div>
                                <div class="calendar-cell" data-cell="18"
                                     style="background-color: {{ $cell_18?->criteria_bg_color }}; border: {{ $cell_18?->criteria_color }} 2px solid;">
                                    18
                                </div>
                                <div class="calendar-cell" data-cell="19"
                                     style="background-color: {{ $cell_19?->criteria_bg_color }}; border: {{ $cell_19?->criteria_color }} 2px solid;">
                                    19
                                </div>
                            </div>
                            <!-- Row 4: 7 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_20 = $healthSafetyCrossCriteria->where('cell_number', 20)->first();
                                    $cell_21 = $healthSafetyCrossCriteria->where('cell_number', 21)->first();
                                    $cell_22 = $healthSafetyCrossCriteria->where('cell_number', 22)->first();
                                    $cell_23 = $healthSafetyCrossCriteria->where('cell_number', 23)->first();
                                    $cell_24 = $healthSafetyCrossCriteria->where('cell_number', 24)->first();
                                    $cell_25 = $healthSafetyCrossCriteria->where('cell_number', 25)->first();
                                    $cell_26 = $healthSafetyCrossCriteria->where('cell_number', 26)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="20"
                                     style="background-color: {{ $cell_20?->criteria_bg_color }}; border: {{ $cell_20?->criteria_color }} 2px solid;">
                                    20
                                </div>
                                <div class="calendar-cell" data-cell="21"
                                     style="background-color: {{ $cell_21?->criteria_bg_color }}; border: {{ $cell_21?->criteria_color }} 2px solid;">
                                    21
                                </div>
                                <div class="calendar-cell" data-cell="22"
                                     style="background-color: {{ $cell_22?->criteria_bg_color }}; border: {{ $cell_22?->criteria_color }} 2px solid;">
                                    22
                                </div>
                                <div class="calendar-cell" data-cell="23"
                                     style="background-color: {{ $cell_23?->criteria_bg_color }}; border: {{ $cell_23?->criteria_color }} 2px solid;">
                                    23
                                </div>
                                <div class="calendar-cell" data-cell="24"
                                     style="background-color: {{ $cell_24?->criteria_bg_color }}; border: {{ $cell_24?->criteria_color }} 2px solid;">
                                    24
                                </div>
                                <div class="calendar-cell" data-cell="25"
                                     style="background-color: {{ $cell_25?->criteria_bg_color }}; border: {{ $cell_25?->criteria_color }} 2px solid;">
                                    25
                                </div>
                                <div class="calendar-cell" data-cell="26"
                                     style="background-color: {{ $cell_26?->criteria_bg_color }}; border: {{ $cell_26?->criteria_color }} 2px solid;">
                                    26
                                </div>
                            </div>

                            <!-- Row 5: 3 cells -21 -->
                            <div class="calendar-row">
                                @php
                                    $cell_27 = $healthSafetyCrossCriteria->where('cell_number', 27)->first();
                                    $cell_28 = $healthSafetyCrossCriteria->where('cell_number', 28)->first();
                                    $cell_29 = $healthSafetyCrossCriteria->where('cell_number', 29)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="27"
                                     style="background-color: {{ $cell_27?->criteria_bg_color }}; border: {{ $cell_27?->criteria_color }} 2px solid;">
                                    27
                                </div>
                                <div class="calendar-cell" data-cell="28"
                                     style="background-color: {{ $cell_28?->criteria_bg_color }}; border: {{ $cell_28?->criteria_color }} 2px solid;">
                                    28
                                </div>
                                <div class="calendar-cell" data-cell="29"
                                     style="background-color: {{ $cell_29?->criteria_bg_color }}; border: {{ $cell_29?->criteria_color }} 2px solid;">
                                    29
                                </div>
                            </div>

                            <!-- Row 6: 2 cells -->
                            <div class="calendar-row">
                                @php
                                    $cell_30 = $healthSafetyCrossCriteria->where('cell_number', 30)->first();
                                    $cell_31 = $healthSafetyCrossCriteria->where('cell_number', 31)->first();
                                @endphp
                                <div class="calendar-cell" data-cell="30"
                                     style="background-color: {{ $cell_30?->criteria_bg_color }}; border: {{ $cell_30?->criteria_color }} 2px solid;">
                                    30
                                </div>
                                <div class="calendar-cell" data-cell="31"
                                     style="background-color: {{ $cell_31?->criteria_bg_color }}; border: {{ $cell_31?->criteria_color }} 2px solid;">
                                    31
                                </div>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="legend">
                            @forelse ($crossCriteria as $legend)
                                <div class="legend-item" data-name="{{ $legend->name }}"
                                     data-color="{{ $legend->criteria_color }}"
                                     data-bg-color="{{ $legend->bg_color }}"
                                     data-description="{{ $legend->description }}">
                                    <div class="color-box"
                                         style="background-color: {{ $legend->bg_color }}; border-color: {{ $legend->criteria_color }};">
                                        {{ $legend->name }}
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<div id="crossCriteriaViewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title cross-criteria-title" id="myModalLabel">Modal Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="cross-criteria-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).on('click', '.legend-item', function () {
        let name = $(this).data('name');
        let color = $(this).data('color');
        let bg_color = $(this).data('bg-color');
        let description = $(this).data('description');
        $('#crossCriteriaViewModal .cross-criteria-title').text(name);
        $('#crossCriteriaViewModal .cross-criteria-content').html(`
                <div style="border: ${color} 2px solid; background-color: ${bg_color};padding: 10px; border-radius: 5px;">
                    ${description}
                    </div>
                `);
        $('#crossCriteriaViewModal').modal('show');
    });
</script>

<style>
    .safety-calendar-board {
        max-width: 1000px;
        margin: auto;
        background: #fff;
        padding: 20px;
        display: flex;
        flex-direction: row;
        gap: 20px;
        flex-wrap: wrap;
    }

    .calendar {
        flex: 3;
        min-width: 280px;
    }

    .calendar-row {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
        gap: 5px;
        flex-wrap: wrap;
    }

    .calendar-cell {
        flex: 0 0 85px;
        height: 80px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        font-weight: bold;
        box-sizing: border-box;
        background: white;
        font-size: 14px;
        text-align: center;
    }

    .legend {
        flex: 1;
        min-width: 164px;
        max-width: 170px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
        cursor: pointer;
    }

    .color-box {
        width: 150px;
        height: 120px;
        margin-right: 4px;
        border: 2px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 4px;
    }

    .color-blue {
        background-color: #c2e2ff;
        border-color: #007bff;
    }

    .color-green {
        background-color: #baf3cd;
        border-color: #28a745;
    }

    .color-yellow {
        background-color: #fff3cd;
        border-color: #ffc107;
    }

    .color-red {
        background-color: #f8d7da;
        border-color: #dc3545;
    }

    @media (max-width: 768px) {
        .safety-calendar-board {
            flex-direction: column;
            align-items: center;
        }

        .calendar-cell {
            flex: 0 0 70px;
            height: 70px;
            font-size: 12px;
        }

        .calendar-title {
            font-size: 16px;
        }

        .legend {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .legend-item {
            width: 100%;
            margin-bottom: 10px;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .safety-calendar-board {
            padding: 20px 5px;
        }

        .calendar-row {
            flex-wrap: nowrap;
        }

        .calendar-cell {
            flex: 0 0 38px;
            height: 38px;
            font-size: 10px;
            padding: 3px;
        }

        .legend-item {
            width: 100%;
            justify-content: center;
        }
    }
</style>
