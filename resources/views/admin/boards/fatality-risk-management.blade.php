<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">
                {{ucfirst($shift)}} Shift FRM Control Board
            </h5>
        </div>
        <div class="col-2 col-md-2 text-end text-md-center">
            <img src="{{ asset('assets/logos/koormal-logo.png') }}" class="img-fluid header-logo float-end">
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex align-items-center justify-content-between">
        <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1" id="previousStepBtn">
            <i class="bi bi-caret-left-fill"></i>
            Previous
        </button>
    </div>
</div>

<script>
    $('#previousStepBtn').on('click', function() {
        currentStep = 7;
        $('#board-header').removeClass('mb-1');
        $('#board-header').addClass('mb-3');
        $('#board-info').addClass('d-none');
        updateBoard(currentStep, "Our Productivity");
    });
</script>