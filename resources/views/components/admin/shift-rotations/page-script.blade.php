@php
    $dayShiftsOptions = $dayShifts->map(function ($shift) {
        $option = [
            'value' => $shift->id,
            'label' => $shift->name,
        ];
        if ($shift->linked_shift_id) {
            $option['data'] = ['linked' => $shift->linked_shift_id];
        }
        return $option;
    });
@endphp
@section('page-script')
    <script>
        $(document).ready(function() {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('shift-rotations.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'week_index',
                        name: 'week_index'
                    },
                    {
                        data: 'day_shift',
                        name: 'day_shift'
                    },
                    {
                        data: 'night_shift',
                        name: 'night_shift'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#addShiftRotationBtn').on('click', function() {
                openDynamicFormModal({
                    modalId: 'addOrEditShiftRotationModal',
                    formId: 'shiftRotationAddForm',
                    title: 'Add a new shift rotation',
                    action: "{{ route('shift-rotations.store') }}",
                    method: 'POST',
                    fields: [{
                            name: 'week_index',
                            type: 'select',
                            required: true,
                            label: 'Week',
                            options: [{
                                    value: '',
                                    label: 'Select week'
                                },
                                {
                                    value: '0',
                                    label: 'Week 1'
                                },
                                {
                                    value: '1',
                                    label: 'Week 2'
                                },
                                {
                                    value: '2',
                                    label: 'Week 3'
                                },
                                {
                                    value: '3',
                                    label: 'Week 4'
                                }
                            ]
                        },
                        {
                            name: 'day_shift_id',
                            type: 'select',
                            required: true,
                            label: 'Day Shift',
                            options: [{
                                    value: '',
                                    label: 'Select Day Shift'
                                },
                                @foreach ($dayShifts as $shift)
                                    {
                                        value: '{{ $shift->id }}',
                                        label: '{{ $shift->name }}'
                                        @if ($shift->linked_shift_id !== null)
                                            , data: {
                                                linked: '{{ $shift->linked_shift_id }}'
                                            }
                                        @endif
                                    }
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            ]
                        },
                        {
                            name: 'night_shift_id',
                            type: 'select',
                            required: true,
                            label: 'Night Shift',
                            options: [{
                                    value: '',
                                    label: 'Select Night Shift'
                                },
                                @foreach ($nightShifts as $shift)
                                    {
                                        value: '{{ $shift->id }}',
                                        label: '{{ $shift->name }}'
                                    },
                                @endforeach
                            ]
                        }
                    ]
                });
            });

            $(document).on('change', '#day_shift_id', function() {
                const linkedId = $(this).find('option:selected').data('linked');

                if (linkedId) {
                    $('#night_shift_id').val(linkedId);
                }
            });


            $('#shiftRotationAddForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        ajaxBeforeSend('#shiftRotationAddForm', '#formSubmitBtn');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addOrEditShiftRotationModal').modal('hide');
                            table.ajax.reload();
                            $('#shiftRotationAddForm')[0].reset();
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#formSubmitBtn');
                    }
                });
            });

            // Reset modal when closed
            $('#addOrEditShiftRotationModal').on('hidden.bs.modal', function() {
                $('#shiftRotationAddForm')[0].reset();
                $('#method').val('POST');
                $('#shiftRotationAddForm').attr('action', "{{ route('shift-rotations.store') }}");
                $('#addOrEditShiftRotationModalLabel').text('Add a new shift rotation');
            });

            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $('#loader').show();

                let editUrl = "{{ route('shift-rotations.edit', ':id') }}".replace(':id', id);

                $.get(editUrl, function(data) {
                    $('#loader').hide();

                    openDynamicFormModal({
                        modalId: 'addOrEditShiftRotationModal',
                        formId: 'shiftRotationAddForm',
                        title: 'Edit Shift Rotation',
                        action: "{{ route('shift-rotations.update', ':id') }}".replace(
                            ':id', id),
                        method: 'PUT',
                        fields: [{
                                name: 'week_index',
                                type: 'select',
                                options: [{
                                        value: '',
                                        label: 'Select week'
                                    },
                                    {
                                        value: '0',
                                        label: 'Week 1'
                                    },
                                    {
                                        value: '1',
                                        label: 'Week 2'
                                    },
                                    {
                                        value: '2',
                                        label: 'Week 3'
                                    },
                                    {
                                        value: '3',
                                        label: 'Week 4'
                                    }
                                ],
                                required: true,
                                label: 'Week'
                            },
                            {
                                name: 'day_shift_id',
                                type: 'select',
                                required: true,
                                label: 'Day Shift',
                                options: [{
                                        value: '',
                                        label: 'Select Day Shift'
                                    },
                                    @foreach ($dayShifts as $shift)
                                        {
                                            value: '{{ $shift->id }}',
                                            label: '{{ $shift->name }}'
                                            @if ($shift->linked_shift_id !== null)
                                                , data: {
                                                    linked: '{{ $shift->linked_shift_id }}'
                                                }
                                            @endif
                                        }
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                ]
                            },
                            {
                                name: 'night_shift_id',
                                type: 'select',
                                required: true,
                                label: 'Night Shift',
                                options: [{
                                        value: '',
                                        label: 'Select Night Shift'
                                    },
                                    @foreach ($nightShifts as $shift)
                                        {
                                            value: '{{ $shift->id }}',
                                            label: '{{ $shift->name }}'
                                        },
                                    @endforeach
                                ]
                            }
                        ]
                    });
                    $('#week_index').val(data.data.week_index);
                    $('#day_shift_id').val(data.data.day_shift_id);
                    $('#night_shift_id').val(data.data.night_shift_id);
                }).fail(function() {
                    $('#loader').hide();
                    notify('error', 'Something went wrong. Please try again.');
                });
            });


            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('shift-rotations.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteShiftRotationModal').modal('show');
            });

            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        ajaxBeforeSend('#deleteForm', '#deleteBtn');
                    },
                    success: function(response) {
                        $('#deleteShiftRotationModal').modal('hide');
                        table.ajax.reload();
                        notify('success', response.message);
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#deleteBtn', 'Delete');
                    }
                });
            });


        });
    </script>
@endsection
