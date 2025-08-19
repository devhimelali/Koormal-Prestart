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
        <div class="col-12">
            <div class="row g-3">
                @forelse($fatalityRisks as $fatalityRisk)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card h-100 shadow-sm border-0 rounded-3 risk-card hover-shadow"
                             data-risk-id="{{ $fatalityRisk->id }}" style="cursor: pointer;">
                            <div class="card-body bg-white text-center p-3 border shadow">
                                <img src="{{ asset('storage/'.$fatalityRisk->image) }}"
                                     class="img-fluid rounded"
                                     alt="{{ $fatalityRisk->name }}"
                                     style="max-height: 120px; object-fit: contain;">
                                <h6 class="mt-3 mb-0 " title="{{ $fatalityRisk->name }}">
                                    {{ $fatalityRisk->name }}
                                </h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        No fatality risks available.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

        .selected-risk {
            border: 3px solid #2ecc71 !important;
            transform: scale(1.05);
        }
    </style>


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

    <x-modal id="controlListModal" title="Control List" :staticBackdrop="true"
             size="modal-lg"
             :scrollable="true">

    </x-modal>
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

    $(document).on('click', '.risk-card', function () {
        $('.risk-card').removeClass('selected-risk');
        $(this).addClass('selected-risk');

        let riskId = $(this).data('risk-id');
        let riskName = $(this).find('h6').text();
        let riskImage = $(this).find('img').attr('src');

        $.ajax({
            url: "{{ route('get-control-list-for-fatal-risk-to-discuss') }}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                risk_id: riskId,
            },
            success: function (response) {
                $('#controlListModal .modal-title').html(`
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <img src="${riskImage}" alt="${riskName}" width="35"
                                 class="img-fluid">
                        </div>
                        <div>
                            <h5 class="mb-0">${riskName}</h5>
                        </div>
                    </div>
                `);
                $('#controlListModal .modal-body').html(response);
                $('#controlListModal').modal('show');
            }
        })
    });

    $(document).on('change', '#control', function () {
        $('#discussNoteDiv').removeClass('d-none');
    });
</script>
