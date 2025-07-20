<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">What is our assessment of our <br />
                <span style="color: #202a44;">Health & Safety performance during the last shift?</span>
            </h5>
        </div>
        <div class="col-2 col-md-2 text-end text-md-center">
            <img src="{{ asset('assets/logos/koormal-logo.png') }}" class="img-fluid header-logo float-end">
        </div>
    </div>

    <div class="safety-calendar-board my-4">
        <div class="calendar">
            <!-- Row 1: 2 cells -->
            <div class="calendar-row">
                @php
                    $cell_1 = $safetyCalendar->where('cell_number', 1)->first();
                    $cell_2 = $safetyCalendar->where('cell_number', 2)->first();
                @endphp
                <div class="calendar-cell green" data-cell="1"
                    style="background-color: {{ $cell_1?->crossCriteria?->bg_color }}; border: {{ $cell_1?->crossCriteria?->color }} 2px solid;">
                    1</div>
                <div class="calendar-cell green" data-cell="2"
                    style="background-color: {{ $cell_2?->crossCriteria?->bg_color }}; border: {{ $cell_2?->crossCriteria?->color }} 2px solid;">
                    2</div>
            </div>

            <!-- Row 2: 3 cells -->
            <div class="calendar-row">
                @php
                    $cell_3 = $safetyCalendar->where('cell_number', 3)->first();
                    $cell_4 = $safetyCalendar->where('cell_number', 4)->first();
                    $cell_5 = $safetyCalendar->where('cell_number', 5)->first();
                @endphp
                <div class="calendar-cell green" data-cell="3"
                    style="background-color: {{ $cell_3?->crossCriteria?->bg_color }}; border: {{ $cell_3?->crossCriteria?->color }} 2px solid;">
                    3</div>
                <div class="calendar-cell" data-cell="4"
                    style="background-color: {{ $cell_4?->crossCriteria?->bg_color }}; border: {{ $cell_4?->crossCriteria?->color }} 2px solid;">
                    4</div>
                <div class="calendar-cell green" data-cell="5"
                    style="background-color: {{ $cell_5?->crossCriteria?->bg_color }}; border: {{ $cell_5?->crossCriteria?->color }} 2px solid;">
                    5</div>
            </div>

            <!-- Row 3: 7 cells -->
            <div class="calendar-row">
                @php
                    $cell_6 = $safetyCalendar->where('cell_number', 6)->first();
                    $cell_7 = $safetyCalendar->where('cell_number', 7)->first();
                    $cell_8 = $safetyCalendar->where('cell_number', 8)->first();
                    $cell_9 = $safetyCalendar->where('cell_number', 9)->first();
                    $cell_10 = $safetyCalendar->where('cell_number', 10)->first();
                    $cell_11 = $safetyCalendar->where('cell_number', 11)->first();
                    $cell_12 = $safetyCalendar->where('cell_number', 12)->first();
                @endphp
                <div class="calendar-cell blue" data-cell="6"
                    style="background-color: {{ $cell_6?->crossCriteria?->bg_color }}; border: {{ $cell_6?->crossCriteria?->color }} 2px solid;">
                    6</div>
                <div class="calendar-cell" data-cell="7"
                    style="background-color: {{ $cell_7?->crossCriteria?->bg_color }}; border: {{ $cell_7?->crossCriteria?->color }} 2px solid;">
                    7</div>
                <div class="calendar-cell" data-cell="8"
                    style="background-color: {{ $cell_8?->crossCriteria?->bg_color }}; border: {{ $cell_8?->crossCriteria?->color }} 2px solid;">
                    8</div>
                <div class="calendar-cell" data-cell="9"
                    style="background-color: {{ $cell_9?->crossCriteria?->bg_color }}; border: {{ $cell_9?->crossCriteria?->color }} 2px solid;">
                    9</div>
                <div class="calendar-cell" data-cell="10"
                    style="background-color: {{ $cell_10?->crossCriteria?->bg_color }}; border: {{ $cell_10?->crossCriteria?->color }} 2px solid;">
                    10</div>
                <div class="calendar-cell" data-cell="11"
                    style="background-color: {{ $cell_11?->crossCriteria?->bg_color }}; border: {{ $cell_11?->crossCriteria?->color }} 2px solid;">
                    11</div>
                <div class="calendar-cell" data-cell="12"
                    style="background-color: {{ $cell_12?->crossCriteria?->bg_color }}; border: {{ $cell_12?->crossCriteria?->color }} 2px solid;">
                    12</div>
            </div>

            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                @php
                    $cell_13 = $safetyCalendar->where('cell_number', 13)->first();
                    $cell_14 = $safetyCalendar->where('cell_number', 14)->first();
                    $cell_15 = $safetyCalendar->where('cell_number', 15)->first();
                    $cell_16 = $safetyCalendar->where('cell_number', 16)->first();
                    $cell_17 = $safetyCalendar->where('cell_number', 17)->first();
                    $cell_18 = $safetyCalendar->where('cell_number', 18)->first();
                    $cell_19 = $safetyCalendar->where('cell_number', 19)->first();
                @endphp
                <div class="calendar-cell" data-cell="13"
                    style="background-color: {{ $cell_13?->crossCriteria?->bg_color }}; border: {{ $cell_13?->crossCriteria?->color }} 2px solid;">
                    13</div>
                <div class="calendar-cell" data-cell="14"
                    style="background-color: {{ $cell_14?->crossCriteria?->bg_color }}; border: {{ $cell_14?->crossCriteria?->color }} 2px solid;">
                    14</div>
                <div class="calendar-cell" data-cell="15"
                    style="background-color: {{ $cell_15?->crossCriteria?->bg_color }}; border: {{ $cell_15?->crossCriteria?->color }} 2px solid;">
                    15</div>
                <div class="calendar-cell" data-cell="16"
                    style="background-color: {{ $cell_16?->crossCriteria?->bg_color }}; border: {{ $cell_16?->crossCriteria?->color }} 2px solid;">
                    16</div>
                <div class="calendar-cell" data-cell="17"
                    style="background-color: {{ $cell_17?->crossCriteria?->bg_color }}; border: {{ $cell_17?->crossCriteria?->color }} 2px solid;">
                    17</div>
                <div class="calendar-cell" data-cell="18"
                    style="background-color: {{ $cell_18?->crossCriteria?->bg_color }}; border: {{ $cell_18?->crossCriteria?->color }} 2px solid;">
                    18</div>
                <div class="calendar-cell" data-cell="19"
                    style="background-color: {{ $cell_19?->crossCriteria?->bg_color }}; border: {{ $cell_19?->crossCriteria?->color }} 2px solid;">
                    19</div>
            </div>
            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                @php
                    $cell_20 = $safetyCalendar->where('cell_number', 20)->first();
                    $cell_21 = $safetyCalendar->where('cell_number', 21)->first();
                    $cell_22 = $safetyCalendar->where('cell_number', 22)->first();
                    $cell_23 = $safetyCalendar->where('cell_number', 23)->first();
                    $cell_24 = $safetyCalendar->where('cell_number', 24)->first();
                    $cell_25 = $safetyCalendar->where('cell_number', 25)->first();
                    $cell_26 = $safetyCalendar->where('cell_number', 26)->first();
                @endphp
                <div class="calendar-cell" data-cell="20"
                    style="background-color: {{ $cell_20?->crossCriteria?->bg_color }}; border: {{ $cell_20?->crossCriteria?->color }} 2px solid;">
                    20</div>
                <div class="calendar-cell" data-cell="21"
                    style="background-color: {{ $cell_21?->crossCriteria?->bg_color }}; border: {{ $cell_21?->crossCriteria?->color }} 2px solid;">
                    21</div>
                <div class="calendar-cell" data-cell="22"
                    style="background-color: {{ $cell_22?->crossCriteria?->bg_color }}; border: {{ $cell_22?->crossCriteria?->color }} 2px solid;">
                    22</div>
                <div class="calendar-cell" data-cell="23"
                    style="background-color: {{ $cell_23?->crossCriteria?->bg_color }}; border: {{ $cell_23?->crossCriteria?->color }} 2px solid;">
                    23</div>
                <div class="calendar-cell" data-cell="24"
                    style="background-color: {{ $cell_24?->crossCriteria?->bg_color }}; border: {{ $cell_24?->crossCriteria?->color }} 2px solid;">
                    24</div>
                <div class="calendar-cell" data-cell="25"
                    style="background-color: {{ $cell_25?->crossCriteria?->bg_color }}; border: {{ $cell_25?->crossCriteria?->color }} 2px solid;">
                    25</div>
                <div class="calendar-cell" data-cell="26"
                    style="background-color: {{ $cell_26?->crossCriteria?->bg_color }}; border: {{ $cell_26?->crossCriteria?->color }} 2px solid;">
                    26</div>
            </div>

            <!-- Row 5: 3 cells -21 -->
            <div class="calendar-row">
                @php
                    $cell_27 = $safetyCalendar->where('cell_number', 27)->first();
                    $cell_28 = $safetyCalendar->where('cell_number', 28)->first();
                    $cell_29 = $safetyCalendar->where('cell_number', 29)->first();
                @endphp
                <div class="calendar-cell" data-cell="27"
                    style="background-color: {{ $cell_27?->crossCriteria?->bg_color }}; border: {{ $cell_27?->crossCriteria?->color }} 2px solid;">
                    27</div>
                <div class="calendar-cell" data-cell="28"
                    style="background-color: {{ $cell_28?->crossCriteria?->bg_color }}; border: {{ $cell_28?->crossCriteria?->color }} 2px solid;">
                    28</div>
                <div class="calendar-cell" data-cell="29"
                    style="background-color: {{ $cell_29?->crossCriteria?->bg_color }}; border: {{ $cell_29?->crossCriteria?->color }} 2px solid;">
                    29</div>
            </div>

            <!-- Row 6: 2 cells -->
            <div class="calendar-row">
                @php
                    $cell_30 = $safetyCalendar->where('cell_number', 30)->first();
                    $cell_31 = $safetyCalendar->where('cell_number', 31)->first();
                @endphp
                <div class="calendar-cell" data-cell="30"
                    style="background-color: {{ $cell_30?->crossCriteria?->bg_color }}; border: {{ $cell_30?->crossCriteria?->color }} 2px solid;">
                    30</div>
                <div class="calendar-cell" data-cell="31"
                    style="background-color: {{ $cell_31?->crossCriteria?->bg_color }}; border: {{ $cell_31?->crossCriteria?->color }} 2px solid;">
                    31</div>
            </div>
        </div>

        <!-- Legend -->
        <div class="legend">
            {{-- <div style="margin-bottom: 10px;">
                <button type="button" class="btn btn-danger d-flex align-items-center gap-1" id="resetLegendBtn">
                    <i class="ph ph-clock-clockwise"></i>
                    Reset
                </button>
            </div> --}}
            @forelse ($crossCriteria as $legend)
                <div class="legend-item" data-name="{{ $legend->name }}" data-color="{{ $legend->color }}"
                    data-bg-color="{{ $legend->bg_color }}" data-description="{{ $legend->description }}">
                    <div class="color-box"
                        style="background-color: {{ $legend->bg_color }}; border-color: {{ $legend->color }};">
                        {{ $legend->name }}
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <button type="button" class="btn btn-danger d-flex align-items-center gap-1" id="previousStepBtn">
            <i class="bi bi-caret-left-fill"></i>
            Previous
        </button>
        <button type="button" class="btn btn-secondary d-flex align-items-center gap-1" id="nextStepBtn">
            Next
            <i class="bi bi-caret-right-fill"></i>
        </button>
    </div>
</div>
@include('components.admin.boards.modal.safety-calendar')
<script>
    $('#previousStepBtn').on('click', function() {
        currentStep = 2;
        updateBoard(currentStep);
    })

    $('#nextStepBtn').on('click', function() {
        currentStep = 4;
        updateBoard(currentStep, "Our Productivity");
    })
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
