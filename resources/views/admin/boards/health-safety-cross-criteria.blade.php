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
    <div class="row my-4">
        <div class="calendar mb-4">
            <!-- Row 1 -->
            <div class="blank"></div>
            <div class="blank"></div>
            <div class="blank"></div>
            <div class="cell sustainable">1</div>
            <div class="cell sustainable">2</div>
            <div class="blank"></div>
            <div class="blank"></div>

            <!-- Row 2 -->
            <div class="blank"></div>
            <div class="blank"></div>
            <div class="cell sustainable">2</div>
            <div class="cell sustainable">3</div>
            <div class="cell sustainable">4</div>
            <div class="blank"></div>
            <div class="blank"></div>

            <!-- Row 3 -->
            <div class="blank"></div>
            <div class="cell sustainable">5</div>
            <div class="cell sustainable">6</div>
            <div class="cell sustainable">7</div>
            <div class="cell sustainable">8</div>
            <div class="cell sustainable">9</div>
            <div class="blank"></div>

            <!-- Row 4 -->
            <div class="cell healthy">10</div>
            <div class="cell">11</div>
            <div class="cell">12</div>
            <div class="cell">13</div>
            <div class="cell">14</div>
            <div class="cell less-healthy">15</div>
            <div class="cell">16</div>

            <!-- Row 5 -->
            <div class="cell">17</div>
            <div class="cell less-healthy">18</div>
            <div class="cell less-healthy">19</div>
            <div class="cell healthy">20</div>
            <div class="cell sustainable">21</div>
            <div class="cell sustainable">22</div>
            <div class="cell sustainable">23</div>

            <!-- Row 6 -->
            <div class="cell sustainable">24</div>
            <div class="cell sustainable">25</div>
            <div class="cell sustainable">26</div>
            <div class="cell sustainable">27</div>
            <div class="cell">28</div>
            <div class="cell">29</div>
            <div class="cell">30</div>
            <div class="cell">31</div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 legend-box">
                <div class="legend-item">
                    <div class="legend-color sustainable"></div>
                    <div>Sustainable Health and Safety Improvement</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color healthy"></div>
                    <div>Healthy Safe Shift</div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 legend-box">
                <div class="legend-item">
                    <div class="legend-color less-healthy"></div>
                    <div>Less Healthy or Safe Shift</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color unhealthy"></div>
                    <div>Unhealthy and/or less Safe Shift</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end">
    <button type="button" class="btn btn-secondary d-flex align-items-center gap-1" id="nextStepBtn">
        Next
        <i class="bi bi-caret-right-fill"></i>
    </button>
</div>
</div>


<style>
    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        justify-content: center;
    }

    .cell {
        border: 1px solid #ccc;
        aspect-ratio: 1 / 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        background-color: #fff;
    }

    .blank {
        background: transparent;
        border: none;
    }

    .sustainable {
        background-color: #a3d9c9;
    }

    .healthy {
        background-color: #d9eaf7;
    }

    .less-healthy {
        background-color: #b3d6f2;
    }

    .unhealthy {
        background-color: #f4c7c3;
    }

    .legend-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 0.9rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border: 1px solid #000;
    }

    .bordered {
        border: 2px solid #000;
        padding: 5px;
    }

    @media (max-width: 768px) {
        .calendar {
            grid-template-columns: repeat(6, 1fr);
        }
    }

    @media (max-width: 576px) {
        .calendar {
            grid-template-columns: repeat(5, 1fr);
        }

        .assessment-title {
            font-size: 1rem;
        }
    }
</style>
