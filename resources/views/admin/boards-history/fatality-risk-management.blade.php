<div class="card">
    <div class="card-body" style="background: #fff">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Supervisor Name :</h5>
                        <p class="text-muted mb-0 text-center">{{ $supervisor ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-auto bg-white p-3 border mb-3 rounded shadow-sm text-center" id="board-header">
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $start_date }} to
                    {{ $end_date }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Shift: </strong>
                    {{ ucfirst($shift_type) }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crew) }}
                </p>
            </div>
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0 ms-auto">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Labour Name :</h5>
                        <p class="text-muted mb-0 text-center" id="labour-name">{{ $labour ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <style>
                .name-card-body {
                    padding: 0.5rem;
                    border-radius: 0% 0% 4px 4px;
                }
            </style>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card shadow">
        <div class="card-header text-center">
            <h4 class="card-title mb-0" id="board-title">Fatality Risk Management (FRM) Job Risk Control Board</h4>
        </div>
        <div class="card-body">
            <div class="board-container">


                <div class="board">
                    <!-- Header with Logos and Title -->
                    <div class="row align-items-center board-header mb-3">
                        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
                            <img src="{{ asset('assets/logos/4emus-logo.png') }}"
                                 class="img-fluid header-logo float-start">
                        </div>
                        <div class="col-8 col-md-8 text-center">
                            <h5 class="board-title mb-0">
                                Day / Night Shift Control Board
                            </h5>
                        </div>
                        <div class="col-2 col-md-2 text-end text-md-center">
                            <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                 class="img-fluid header-logo float-end">
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
                        ]">
                        @forelse($fatalityRiskManagements as $shiftLog)
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
                                        @forelse($shiftLog->fatalityRisks as $fatality_risk_control)
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
                                                </button>
                                            </div>
                                        @empty
                                            N/A
                                        @endforelse
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
                </div>


            </div>
        </div>
    </div>
</div>

<x-modal id="hazardControlListModal" title="Hazard Control" :staticBackdrop="true"
         size="modal-lg"
         :scrollable="true">
</x-modal>

<script>
    $('.hazardControlList').on('click', function () {
        let fatalityRiskId = $(this).data('fatality-risk-id');
        let shiftLogId = $(this).data('shift-log-id');
        getHazardControlList(fatalityRiskId, shiftLogId);
    })

    function getHazardControlList(fatalityRiskId, shiftLogId) {
        $.ajax({
            url: "{{route('hazard-controls-archive.index')}}",
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
</script>
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
