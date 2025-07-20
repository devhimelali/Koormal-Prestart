<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">
                Celebrate Success
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
                <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1"
                    id="addSuccessNoteBtn">
                    <i class="ph ph-plus"></i>
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <tbody>
                        @forelse ($celebrateSuccesses as $celebrateSuccess)
                            <tr class="align-middle">
                                <td class="p-1 align-top w-auto">
                                    <div contenteditable="true" class="success-note" data-date=""
                                        style="
            border: 1px solid #ccc;
                 padding: 6px 8px;
                 min-height: 25px;
                 width: 100%;
                 box-sizing: border-box;
                 word-break: break-word;
                 overflow-wrap: break-word;
                 white-space: normal;
                 background-color: #fff;
                 border-radius: 4px;
        ">
                                        {{ $celebrateSuccess->note }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
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

<script>
    $('#previousStepBtn').on('click', function() {
        currentStep = 5;
        updateBoard(currentStep, "Our Productivity");
    })

    $('#nextStepBtn').on('click', function() {
        currentStep = 7;
        updateBoard(currentStep, "Site Communication");
    })
</script>
