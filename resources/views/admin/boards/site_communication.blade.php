<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">
                Site Communication
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
                @if(!$disabled)
                    <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1"
                            id="addSiteCommunicationBtn">
                        <i class="ph ph-plus"></i>
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <tbody>
                    @forelse ($siteCommunications as $siteCommunication)
                        @php
                            $today = \Carbon\Carbon::now()->format('d-m-Y');
                            $isNotEditable = $siteCommunication->date !== $today;
                        @endphp
                        <tr class="align-middle">
                            <td class="bg-light td-date">
                                    <span>
                                        {{ $siteCommunication->date }}
                                        ({{ \Carbon\Carbon::parse($siteCommunication->date)->format('l') }})
                                    </span>
                            </td>
                            <td class="p-1 align-top w-auto">
                                <div contenteditable="{{($disabled || $isNotEditable) ? 'false' : 'true'}}"
                                     class="{{($disabled || $isNotEditable) ? '' : 'site-communication-note'}}"
                                     data-date="{{$siteCommunication->date}}"
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
                                    {{ $siteCommunication->note }}
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
        currentStep = 6;
        updateBoard(currentStep, "Our Productivity");
    });

    $('#nextStepBtn').on('click', function () {
        currentStep = 8;
        $('#board-header').removeClass('mb-3');
        $('#board-header').addClass('mb-1');
        $('#board-info').removeClass('d-none');
        updateBoard(currentStep, "Fatality Risk Management (FRM) Job Risk Control Board");
        getSupervisorAndLabour();
    });
</script>
