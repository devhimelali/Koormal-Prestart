<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">
                Given our tasks this shift which Fatal Risk(s) are present? <br>
                <span class="mt-2">
                    (Circle and Discuss)
                </span>
            </h5>
        </div>
        <div class="col-2 col-md-2 text-end text-md-center">
            <img src="{{ asset('assets/logos/koormal-logo.png') }}" class="img-fluid header-logo float-end">
        </div>
    </div>

    <div class="row mb-4">
        <!-- Question 1 -->
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center flex-wrap mb-2">

            </div>

            <div class="table-responsive">

            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex align-items-center justify-content-between">
        <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1" id="previousStepBtn">
            <i class="bi bi-caret-left-fill"></i>
            Previous
        </button>
        <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-1" id="nextStepBtn">
            Next
            <i class="bi bi-caret-right-fill"></i>
        </button>
    </div>
</div>
<script>
    $('#previousStepBtn').on('click', function () {
        currentStep = 9;
        updateBoard(currentStep, "Improve our performance");
    });

    $('#nextStepBtn').on('click', function () {
        currentStep = 11;
        updateBoard(currentStep, "Health and safety focus");
    })
</script>
