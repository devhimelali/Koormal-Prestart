@section('page-script')
    <script>
        $(document).ready(function() {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rotation-settings.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'rotation_days',
                        name: 'rotation_days'
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

            $('#addRotationSettingBtn').on('click', function() {
                openDynamicFormModal({
                    modalId: 'addOrEditRotationSettingModal',
                    formId: 'rotationSettingAddForm',
                    title: 'Add a new rotation setting',
                    action: "{{ route('rotation-settings.store') }}",
                    method: 'POST',
                    fields: [{
                        name: 'start_date',
                        type: 'text',
                        placeholder: 'Enter rotation setting start date',
                        required: true,
                        label: 'Start Date'
                    }, {
                        name: 'rotation_days',
                        type: 'number',
                        placeholder: 'Enter the number of days for rotation (between 1 and 365)',
                        required: true,
                        label: 'Rotation Days'
                    }]
                });

                $('#start_date').flatpickr({
                    dateFormat: 'd-m-Y',
                    allowInput: true,
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.set('minDate', 'today');
                    }
                });
            });

            $('#rotationSettingAddForm').on('submit', function(e) {
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
                        ajaxBeforeSend('#rotationSettingAddForm', '#formSubmitBtn');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addOrEditRotationSettingModal').modal('hide');
                            table.ajax.reload();
                            $('#rotationSettingAddForm')[0].reset();
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
            $('#addOrEditRotationSettingModal').on('hidden.bs.modal', function() {
                $('#rotationSettingAddForm')[0].reset();
                $('#method').val('POST');
                $('#rotationSettingAddForm').attr('action', "{{ route('rotation-settings.store') }}");
                $('#addOrEditRotationSettingModalLabel').text('Add a new rotation setting');
            });

            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $('#loader').show();

                let editUrl = "{{ route('rotation-settings.edit', ':id') }}".replace(':id', id);

                $.get(editUrl, function(data) {
                    $('#loader').hide();

                    openDynamicFormModal({
                        modalId: 'addOrEditRotationSettingModal',
                        formId: 'rotationSettingAddForm',
                        title: 'Edit Rotation Setting',
                        action: "{{ route('rotation-settings.update', ':id') }}".replace(
                            ':id', id),
                        method: 'PUT',
                        fields: [{
                            label: 'Start Date',
                            name: 'start_date',
                            type: 'text',
                            required: true,
                            value: data.data.start_date
                        }, {
                            label: 'Rotation Days',
                            name: 'rotation_days',
                            type: 'number',
                            required: true,
                            value: data.data.rotation_days
                        }]
                    });

                    $('#start_date').flatpickr({
                        dateFormat: 'd-m-Y',
                        allowInput: true,
                        defaultDate: data.data.start_date,
                        onReady: function(selectedDates, dateStr, instance) {
                            instance.set('minDate', 'today');
                        }
                    });
                }).fail(function() {
                    $('#loader').hide();
                    notify('error', 'Something went wrong. Please try again.');
                });
            });


            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('rotation-settings.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteRotationSettingModal').modal('show');
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
                        $('#deleteRotationSettingModal').modal('hide');
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
