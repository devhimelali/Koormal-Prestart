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
                <div class="calendar-cell green">1</div>
                <div class="calendar-cell green">2</div>
            </div>

            <!-- Row 2: 3 cells -->
            <div class="calendar-row">
                <div class="calendar-cell green">3</div>
                <div class="calendar-cell">4</div>
                <div class="calendar-cell green">5</div>
            </div>

            <!-- Row 3: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell blue">6</div>
                <div class="calendar-cell">7</div>
                <div class="calendar-cell">8</div>
                <div class="calendar-cell">9</div>
                <div class="calendar-cell">10</div>
                <div class="calendar-cell">11</div>
                <div class="calendar-cell">12</div>
            </div>

            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell">13</div>
                <div class="calendar-cell">14</div>
                <div class="calendar-cell">15</div>
                <div class="calendar-cell">16</div>
                <div class="calendar-cell green">17</div>
                <div class="calendar-cell green">18</div>
                <div class="calendar-cell blue">19</div>
            </div>
            <!-- Row 4: 7 cells -->
            <div class="calendar-row">
                <div class="calendar-cell">20</div>
                <div class="calendar-cell">21</div>
                <div class="calendar-cell">22</div>
                <div class="calendar-cell">23</div>
                <div class="calendar-cell green">24</div>
                <div class="calendar-cell green">25</div>
                <div class="calendar-cell blue">26</div>
            </div>

            <!-- Row 5: 3 cells -->
            <div class="calendar-row">
                <div class="calendar-cell green">27</div>
                <div class="calendar-cell green">28</div>
                <div class="calendar-cell green">29</div>
            </div>

            <!-- Row 6: 2 cells -->
            <div class="calendar-row">
                <div class="calendar-cell green">30</div>
                <div class="calendar-cell green">31</div>
            </div>
        </div>
        <!-- Legend -->
        <div class="legend">
            <div class="legend-item">
                <div class="color-box color-blue"></div>
                Sustainable Health and Safety Improvement/s
            </div>
            <div class="legend-item">
                <div class="color-box color-green"></div>
                Healthy & Safe Shift
            </div>
            <div class="legend-item">
                <div class="color-box color-yellow"></div>
                Less Healthy or Safe Shift
            </div>
            <div class="legend-item">
                <div class="color-box color-red"></div>
                Unhealthy and/or less Safe Shift
            </div>
        </div>
    </div>
</div>


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
