<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
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
    <x-table tableVariant="table-sm table-hover table-striped align-middle mb-0" :thead="[
                            [
                                'label' => '#',
                                'class' => 'th-sn',
                            ],
                            [
                                'label' => 'WO Number',
                                'class' => 'th-wo-number',
                            ],
                            [
                                'label' => 'Asset Number',
                                'class' => 'th-asset-number',
                            ],
                            [
                                'label' => 'WO Description',
                                'class' => 'th-wo-description',
                            ],
                            [
                                'label' => 'Labour',
                                'class' => 'th-labour',
                            ],
                            [
                                'label' => 'Scheduled',
                                'class' => 'th-scheduled',
                            ],
                            [
                                'label' => '% Completed',
                                'class' => 'th-completed',
                            ],
                            [
                                'label' => 'Fatality Risk Controls',
                                'class' => 'th-frm',
                            ],
                            [
                                'label' => 'Actions',
                                'class' => 'th-actions',
                            ],
                        ]">
        @forelse($shiftLogs as $shiftLog)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td class="text-center">
                    {{ $shiftLog->wo_number }}
                </td>
                <td>
                    {{ $shiftLog->asset_no }}
                </td>
                <td>
                    {{ $shiftLog->work_description }}
                </td>
                <td>
                    {{ $shiftLog->labour }}
                </td>
                <td class="text-center">
                    {{ ucfirst($shiftLog->scheduled) }}
                </td>
                <td class="text-center">
                    {{ $shiftLog->progress }}
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-1">
                        @forelse($shiftLog->fatality_risk_controls as $fatality_risk_control)
                            <div>
                                @php
                                    $url = asset('storage/'.$fatality_risk_control->image);
                                @endphp
                                <a href="{{ $url }}" class="glightbox" data-gallery="media-gallery">
                                    <img src="{{ $url }}" width="45" height="45"
                                         alt="{{$fatality_risk_control->name}}" loading="lazy">
                                </a>
                            </div>
                        @empty
                            N/A
                        @endforelse
                    </div>
                </td>
                <td>
                    <div class="btn-group">
                        @if($shiftLog->fatality_risk_controls->count() > 0)
                            <button class="btn btn-sm btn-warning" data-shift-log-id="{{ $shiftLog->id }}"
                                    data-fatality-risk-control-ids="{{ implode(',', $shiftLog->fatality_risk_controls->pluck('id')->toArray()) }}">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </button>
                        @else
                            <button class="btn btn-sm btn-secondary" data-shift-log-id="{{ $shiftLog->id }}">
                                <i class="bi bi-plus"></i>
                                Add
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">No data found</td>
            </tr>
        @endforelse
    </x-table>


    <!-- Navigation Buttons -->
    <div class="d-flex align-items-center justify-content-between mt-4">
        <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1" id="previousStepBtn">
            <i class="bi bi-caret-left-fill"></i>
            Previous
        </button>
    </div>
</div>
<style>
    th.th-sn {
        min-width: 40px;
    }

    th.th-wo-number {
        min-width: 100px;
    }

    th.th-asset-number {
        min-width: 115px;
    }

    th.th-wo-description {
        min-width: 250px;
    }

    th.th-labour {
        min-width: 80px;
    }

    th.th-completed {
        min-width: 110px;
    }

    th.th-frm {
        min-width: 175px;
    }

    th.th-actions {
        min-width: 80px;
    }
</style>

<script>
    $('#previousStepBtn').on('click', function () {
        currentStep = 7;
        $('#board-header').removeClass('mb-1');
        $('#board-header').addClass('mb-3');
        $('#board-info').addClass('d-none');
        updateBoard(currentStep, "Our Productivity");
    });
</script>