<div class="board">
    <!-- Header with Logos and Title -->
    <div class="row align-items-center board-header mb-3">
        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
        </div>
        <div class="col-8 col-md-8 text-center">
            <h5 class="board-title mb-0">
                Day / Night Shift Control Board
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
                                <button type="button" class="btn btn-sm btn-link hazardControlList"
                                        data-fatality-risk-id="{{$fatality_risk_control->id}}"
                                        data-shift-log-id="{{$shiftLog->id}}"
                                >
                                    <img src="{{ $url }}" width="45" height="45"
                                         alt="{{$fatality_risk_control->name}}" loading="lazy">
                                    <span class="remove-image"
                                          data-fatality-risk-control-id="{{$fatality_risk_control->id}}"
                                          data-shift-log-id="{{$shiftLog->id}}">
                                        <i class="ph ph-x"></i>
                                    </span>
                                </button>
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
                                Edit
                            </button>
                        @else
                            <button class="btn btn-sm btn-secondary addFatalityRiskControlBtn"
                                    data-shift-log-id="{{ $shiftLog->id }}" data-wo-number="{{ $shiftLog->wo_number }}"
                                    data-asset-no="{{ $shiftLog->asset_no }}">
                                <i class="bi bi-plus"></i>
                                Add
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
    @include('components.admin.hazard-controls.modals.hazard-control-list')
    @include('components.admin.hazard-controls.modals.create-new-hazard-control')
    @include('components.admin.hazard-controls.modals.fatality-controls')
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
        updateBoard(currentStep, "Site Communications");
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

    // when modal is closed
    $('#fatalityRiskControlModal').on('hidden.bs.modal', function () {
        // Clear existing selections
        $('#fatality_risk_control').val([]).trigger('change');
    });

    $('.remove-image').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let fatalityRiskControlId = $(this).data('fatality-risk-control-id');
        let shiftLogId = $(this).data('shift-log-id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
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
            }
        });
    });

    $('.hazardControlList').on('click', function () {
        let fatalityRiskId = $(this).data('fatality-risk-id');
        let shiftLogId = $(this).data('shift-log-id');
        getHazardControlList(fatalityRiskId, shiftLogId);
    })

    function getHazardControlList(fatalityRiskId, shiftLogId) {
        $.ajax({
            url: "{{route('hazard-controls.index')}}",
            type: 'GET',
            data: {
                fatality_risk_id: fatalityRiskId,
                shift_log_id: shiftLogId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (response) {
                $('#hazardControlListModal .modal-body').html(response);
                $('#hazardControlListModal').modal('show');
            },
            error: function () {
                alert('Failed to load the modal. Please try again.');
            },
            complete: function () {
                $('#loader').hide();
            }
        })
    }

    $(document).on('click', '#viewFatalityControlsBtn', function () {
        let fatalityRiskId = $(this).data('fatality-risk-id');
        let shiftLogId = $(this).data('shift-log-id');
        $('#hazardControlListModal').modal('hide');
        $.ajax({
            url: "{{route('get-fatality-controls-list')}}",
            type: 'GET',
            data: {
                fatality_risk_id: fatalityRiskId,
                shift_log_id: shiftLogId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (response) {
                $('#assignFatalityControlModal .modal-body').html(response);
                $('#assignFatalityControlModal').modal('show');
            },
            error: function () {
                alert('Failed to load the modal. Please try again.');
            },
            complete: function () {
                $('#loader').hide();
            }
        })
        // $('#assignFatalityControlModal').modal('show');
        // // alert("Fatality Risk ID: " + fatalityRiskId + "\nShift Log ID: " + shiftLogId + "\n\nThis is a sample alert message.");
    })

    $(document).on('submit', '#assignFatalityControlForm', function (e) {
        e.preventDefault();

        // Get form element
        let formElement = document.getElementById('assignFatalityControlForm');
        let formData = new FormData(formElement);

        // Get specific values from form
        let fatalityRiskId = formData.get('fatality_risk_id');
        let shiftLogId = formData.get('shift_log_id');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData, // sends all form data
            processData: false,
            contentType: false,
            beforeSend: function () {
                ajaxBeforeSend('#assignFatalityControlForm', '#assignFatalityControlSubmitBtn');
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#assignFatalityControlForm')[0].reset();
                    notify('success', response.message);
                    $('#assignFatalityControlModal').modal('hide');
                }
            },
            error: handleAjaxErrors,
            complete: function () {
                ajaxComplete('#assignFatalityControlSubmitBtn', 'Save');
            }
        });

        setTimeout(function () {
            getHazardControlList(fatalityRiskId, shiftLogId);
        }, 500);
    });


    $(document).on('click', '#addHazardControlBtn', function () {
        let fatalityRiskId = $(this).data('fatality-risk-id');
        let shiftLogId = $(this).data('shift-log-id');
        $('#createHazardControlForm #fatality_risk_id').val(fatalityRiskId)
        $('#createHazardControlForm #shift_log_id').val(shiftLogId)
        $('#hazardControlListModal').modal('hide');
        $('#createHazardControlModal').modal('show');
    })

    $('#createHazardControlForm').on('submit', function (e) {
        e.preventDefault();

        // Get form element
        let formElement = document.getElementById('createHazardControlForm');
        let formData = new FormData(formElement);

        // Get specific values from form
        let fatalityRiskId = formData.get('fatality_risk_id');
        let shiftLogId = formData.get('shift_log_id');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData, // sends all form data
            processData: false,
            contentType: false,
            beforeSend: function () {
                ajaxBeforeSend('#createHazardControlForm', '#createHazardControlSubmitBtn');
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#createHazardControlForm')[0].reset();
                    notify('success', response.message);
                    $('#createHazardControlModal').modal('hide');
                }
            },
            error: handleAjaxErrors,
            complete: function () {
                ajaxComplete('#createHazardControlSubmitBtn', 'Save');
            }
        });

        setTimeout(function () {
            getHazardControlList(fatalityRiskId, shiftLogId);
        }, 500);
    });

    $(document).on('click', '.deleteHazardControlBtn', function () {
        let id = $(this).data('hazard-control-id');
        $('#hazardControlListModal').modal('hide');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('hazard-controls.destroy') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                });
            }
        });
    });

</script>
