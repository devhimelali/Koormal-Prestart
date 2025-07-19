@php
    function hexToRgbaBlade($hex, $opacity)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba($r, $g, $b, $opacity)";
    }
@endphp
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
                <div class="calendar-cell green" data-cell="1">1</div>
                <div class="calendar-cell green" data-cell="2">2</div>
            </div>

            <!-- Row 2: 3 cells -->
            <div class="calendar-row">
                <div class="calendar-cell green" data-cell="3">3</div>
                <div class="calendar-cell" data-cell="4">4</div>
                <div class="calendar-cell green" data-cell="5">5</div>
            </div>

            <!-- Row 3: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell blue" data-cell="6">6</div>
                <div class="calendar-cell" data-cell="7">7</div>
                <div class="calendar-cell" data-cell="8">8</div>
                <div class="calendar-cell" data-cell="9">9</div>
                <div class="calendar-cell" data-cell="10">10</div>
                <div class="calendar-cell" data-cell="11">11</div>
                <div class="calendar-cell" data-cell="12">12</div>
            </div>

            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell" data-cell="13">13</div>
                <div class="calendar-cell" data-cell="14">14</div>
                <div class="calendar-cell" data-cell="15">15</div>
                <div class="calendar-cell" data-cell="16">16</div>
                <div class="calendar-cell" data-cell="17">17</div>
                <div class="calendar-cell" data-cell="18">18</div>
                <div class="calendar-cell" data-cell="19">19</div>
            </div>
            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell" data-cell="20">20</div>
                <div class="calendar-cell" data-cell="21">21</div>
                <div class="calendar-cell" data-cell="22">22</div>
                <div class="calendar-cell" data-cell="23">23</div>
                <div class="calendar-cell" data-cell="24">24</div>
                <div class="calendar-cell" data-cell="25">25</div>
                <div class="calendar-cell" data-cell="26">26</div>
            </div>

            <!-- Row 5: 3 cells -->
            <div class="calendar-row">
                <div class="calendar-cell" data-cell="27">27</div>
                <div class="calendar-cell" data-cell="28">28</div>
                <div class="calendar-cell" data-cell="29">29</div>
            </div>

            <!-- Row 6: 2 cells -->
            <div class="calendar-row">
                <div class="calendar-cell" data-cell="30">30</div>
                <div class="calendar-cell" data-cell="31">31</div>
            </div>
        </div>

        <!-- Legend -->
        <div class="legend">
            @forelse ($crossCriteria as $legend)
                <div class="legend-item" data-name="{{ $legend->name }}" data-color="{{ $legend->color }}"
                    data-description="{{ $legend->description }}">
                    <div class="color-box"
                        style="background-color: {{ hexToRgbaBlade($legend->color, 0.3) }}; border-color: {{ $legend->color }};">
                    </div>
                    {{ $legend->name }}
                </div>
            @empty
            @endforelse

        </div>
    </div>
</div>
@include('components.admin.boards.modal.safety-calendar')
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
        flex: 0 0 60px;
        height: 60px;
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
        min-width: 220px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        font-size: 14px;
        cursor: pointer;
    }

    .color-box {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        border: 2px solid #000;
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
            flex: 0 0 45px;
            height: 45px;
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
            width: 45%;
            margin-bottom: 10px;
        }
    }

    @media (max-width: 480px) {
        .calendar-cell {
            flex: 0 0 38px;
            height: 38px;
            font-size: 10px;
            padding: 3px;
        }

        .legend-item {
            width: 100%;
        }
    }
</style>
