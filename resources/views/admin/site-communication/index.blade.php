@extends('layouts.app')
@section('title', 'Site Communications')
@section('content')
    <x-common.breadcrumb :title="'Site Communications'"
                         :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Site Communications']]"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Site Communications</h4>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-1">
                            <label for="crew" class="form-label mb-0" style="min-width: fit-content;">Crew:</label>
                            <select class="form-select form-select-sm" name="shift" id="shift">
                                <option value="">All</option>
                                @forelse($shifts as $shift)
                                    <option value="{{ $shift->name }}">{{ $shift->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <label for="shift_type" class="form-label mb-0" style="min-width: fit-content;">Shift Type:</label>
                            <select class="form-select form-select-sm" name="ft_shift_type" id="ft_shift_type">
                                <option value="">All</option>
                                @forelse($shiftTypes as $shiftType)
                                    <option value="{{ $shiftType->value }}">{{ $shiftType->label() }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <label for="date-range" class="form-label mb-0" style="width: 110px;">Date Range:</label>
                            <input type="text" name="date_range" class="form-control form-control-sm" id="date-range">
                        </div>
                        <div>
                            <button class="btn btn-sm btn-secondary d-flex align-items-center gap-1" data-bs-toggle="modal"
                                    data-bs-target="#addSiteCommunication">
                                <i class="ph ph-plus"></i>
                                Add Site Communication
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <x-table id="dataTable" tableVariant="table-sm table-hover table-striped align-middle mb-0"
                             :thead="[
                            [
                                'label' => '#',
                                'class' => 'th-sn',
                            ],
                            [
                                'label' => 'Title',
                                'class' => 'th-title',
                            ],
                            [
                                'label' => 'Description',
                                'class' => 'th-description',
                            ],
                            [
                                'label' => 'Crew',
                                'class' => 'th-crew',
                            ],
                            [
                                'label' => 'Shift',
                                'class' => 'th-shift',
                            ],
                            [
                                'label' => 'Date',
                                'class' => 'th-date',
                            ],
                            [
                                'label' => 'Actions',
                                'class' => 'th-actions',
                            ],
                        ]"/>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin.site-communication.modals.add-site-communication')
    <x-common.delete-modal id="deleteSiteCommunicationModal" title="Delete Site Communication"
                           message="Are you sure you want to delete this site communication?"/>
@endsection
@include('components.admin.cross-criteria.vendor-script')
@include('components.admin.cross-criteria.vendor-css')
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#dates", {
            mode: "multiple",
            dateFormat: "d-m-Y",
        });

        let startDate = '';
        let endDate = '';

        let table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('site-communications.index') }}" + '?shift_type={{request()->query('shift_type')}}',
                data: function (d) {
                    d.start_date = startDate;
                    d.end_date = endDate;
                    d.shift = $('#shift').val();
                    d.shift_type = $('#ft_shift_type').val();
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'shift',
                    name: 'shift'
                },
                {
                    data: 'shift_type',
                    name: 'shift_type'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#shift').on('change', function () {
            table.ajax.reload();
        });

        $('#shift_type').on('change', function () {
            table.ajax.reload();
        });

        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "d-m-Y",
            onClose: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    startDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                    endDate = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                    table.ajax.reload();
                }
            }
        });

        $('#addSiteCommunicationForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    ajaxBeforeSend('#addSiteCommunicationForm', '#addSiteCommunicationSubmitBtn');
                },
                success: function (response) {
                    $('#addSiteCommunication').modal('hide');
                    table.ajax.reload();
                    notify('success', response.message);
                    $('#addSiteCommunicationForm')[0].reset();
                },
                error: handleAjaxErrors,
                complete: function () {
                    ajaxComplete('#addSiteCommunicationSubmitBtn', 'Save');
                }
            });
        })

        // after hide modal
        $('#addSiteCommunication').on('hidden.bs.modal', function () {
            const form = $('#addSiteCommunicationForm');

            // Reset form
            form[0].reset();

            // Reset title and action
            $('#addSiteCommunication .modal-title').text('Edit site communication');
            $('#method').val('POST');
            form.attr('action', "{{ route('site-communications.store') }}");

            // Remove validation errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove(); // if you add error messages dynamically
        });


        $(document).on('click', '.edit', function () {
            let id = $(this).data('id');
            $('#loader').show();
            let editUrl = "{{ route('site-communications.edit', ':id') }}".replace(':id', id);
            $.get(editUrl, function (response) {
                $('#loader').hide();
                $('#addFatalityRiskControlModal .modal-title').text('Edit site communication');
                $('#method').val('PUT');
                $('#addSiteCommunicationForm').attr('action', "{{ route('site-communications.update', ':id') }}"
                    .replace(':id', id));
                $('#addSiteCommunicationForm #title').val(response.data.title);
                $('#addSiteCommunicationForm #description').val(response.data.description);
                $('#addSiteCommunicationForm #dates').val(response.data.date);
                $('#addSiteCommunicationForm #shift_type').val(response.data.shift_type);
                $('#addSiteCommunication').modal('show');
            });
        })

        $('body').on('click', '.delete', function () {
            let id = $(this).data('id');
            let deleteUrl = "{{ route('site-communications.destroy', ':id') }}".replace(':id', id);
            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteSiteCommunicationModal').modal('show');
        });

        $('#deleteForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                beforeSend: function () {
                    ajaxBeforeSend('#deleteForm', '#deleteBtn');
                },
                success: function (response) {
                    $('#deleteSiteCommunicationModal').modal('hide');
                    table.ajax.reload();
                    notify('success', response.message);
                },
                error: handleAjaxErrors,
                complete: function () {
                    ajaxComplete('#deleteBtn', 'Delete');
                }
            });
        });
    </script>
@endsection
@section('page-css')
    <style>
        th.th-sn {
            min-width: 40px;
            width: 40px;
            max-width: 40px;
        }

        th.th-title {
            min-width: 160px;
            width: 160px;
            max-width: 160px;
        }

        th.th-shift {
            min-width: 60px;
            width: 60px;
            max-width: 60px;
        }

        th.th-crew {
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        th.th-date {
            width: 100px;
            min-width: 100px;
            max-width: 100px;
        }

        th.th-description {
            min-width: 200px;
            width: 200px;
            max-width: 200px;
        }

        th.th-actions {
            min-width: 160px;
            width: 160px;
            max-width: 160px;
        }
    </style>
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">--}}
@endsection
