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
                            <div class="image-container">
                                @php
                                    $url = asset('storage/'.$fatality_risk_control->image);
                                @endphp
                                <a href="{{ $url }}" class="glightbox" data-gallery="media-gallery"
                                   data-glightbox="title:{{$fatality_risk_control->name}}; description:{{$fatality_risk_control->description}}; descPosition: left">
                                    <img src="{{ $url }}" width="45" height="45"
                                         alt="{{$fatality_risk_control->name}}" loading="lazy">
                                    <span class="remove-image"
                                          data-fatality-risk-control-id="{{$fatality_risk_control->id}}"
                                          data-shift-log-id="{{$shiftLog->id}}">
                                        <i class="ph ph-x"></i>
                                    </span>
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
                            <button class="btn btn-sm btn-warning editFatalityRiskControlBtn"
                                    data-shift-log-id="{{ $shiftLog->id }}" data-wo-number="{{ $shiftLog->wo_number }}"
                                    data-asset-no="{{ $shiftLog->asset_no }}"
                                    data-fatality-risk-control-ids="{{ implode(',', $shiftLog->fatality_risk_controls->pluck('id')->toArray()) }}">
                                <i class="bi bi-pencil-square"></i>
                                Edit RFC
                            </button>
                        @else
                            <button class="btn btn-sm btn-secondary addFatalityRiskControlBtn"
                                    data-shift-log-id="{{ $shiftLog->id }}" data-wo-number="{{ $shiftLog->wo_number }}"
                                    data-asset-no="{{ $shiftLog->asset_no }}">
                                <i class="bi bi-plus"></i>
                                Add RFC
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <p class="text-center my-4">No data found</p>
                </td>
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

    @include('components.admin.boards.modal.add-or-edit-fatality-risk-management')
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
        min-width: 215px;
    }

    th.th-actions {
        min-width: 100px;
    }

    label {
        display: block;
    }

    span.select2.select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        display: flex !important;
        align-items: center;
    }

    span.select2-selection__choice__display {
        padding: 3px 0;
    }

    .image-container {
        position: relative;
    }

    span.remove-image {
        background: rgba(255, 0, 0, 0.85);
        width: 18px;
        height: 18px;
        display: inline-block;
        position: absolute;
        text-align: center;
        padding: 2px;
        border-radius: 50%;
        top: -3px;
        right: -3px;
        cursor: pointer;
    }

    span.remove-image i {
        font-size: 10px;
        color: #fff;
        transform: translate(0px, -2px);
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

    $(".addFatalityRiskControlBtn").on('click', function () {
        let shiftLogId = $(this).data('shift-log-id');
        let woNumber = $(this).data('wo-number');
        let assetNo = $(this).data('asset-no');
        $('#inputType').val('add');
        $('#shift_log_id').val(shiftLogId);
        $('.log-details').html(`
            <p class="mb-1">WO Number: <span class="fw-bold">${woNumber}</span></p>
            <p class="mb-1">Asset Number: <span class="fw-bold">${assetNo}</span></p>
        `);
        $('#fatalityRiskControlModal').modal('show');
    });

    $('#fatality_risk_control').select2({
        dropdownParent: $('#fatalityRiskControlModal'),
        templateResult: formatOptionWithImage,
        templateSelection: formatOptionWithImage,
    });

    function formatOptionWithImage(option) {
        if (!option.id) return option.text;

        const imageUrl = $(option.element).data('image');
        const optionText = option.text;

        return $(`
                <span class="d-flex align-items-center">
                    <img src="${imageUrl}" class="me-2 rounded" width="30" height="30" />
                    <span>${optionText}</span>
                </span>
            `);
    }

    $('.editFatalityRiskControlBtn').on('click', function () {
        let shiftLogId = $(this).data('shift-log-id');
        let woNumber = $(this).data('wo-number');
        let assetNo = $(this).data('asset-no');
        let fatalityRiskControlIds = $(this).data('fatality-risk-control-ids').toString().split(',');
        $('#inputType').val('edit');
        // Set hidden field
        $('#shift_log_id').val(shiftLogId);

        // Set WO and Asset info
        $('.log-details').html(`
        <p class="mb-1">WO Number: <span class="fw-bold">${woNumber}</span></p>
        <p class="mb-1">Asset Number: <span class="fw-bold">${assetNo}</span></p>
    `);

        // Clear existing selections
        $('#fatality_risk_control').val(null).trigger('change');

        // Preselect existing risk control IDs
        $('#fatality_risk_control').val(fatalityRiskControlIds).trigger('change');

        // Show modal
        $('#fatalityRiskControlModal').modal('show');
    });

    $('.remove-image').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let fatalityRiskControlId = $(this).data('fatality-risk-control-id');
        let shiftLogId = $(this).data('shift-log-id');

        $.ajax({
            url: "{{route('fatality-risk-controls.delete-image')}}",
            type: 'POST',
            data: {
                fatality_risk_control_id: fatalityRiskControlId,
                shift_log_id: shiftLogId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 'success') {
                    notify('success', response.message);
                    $(`span[data-fatality-risk-control-id="${fatalityRiskControlId}"]`).closest('.image-container').remove();
                }
            },
            error: function () {
                alert('Failed to remove the image. Please try again.');
            }
        });
    });


</script>
