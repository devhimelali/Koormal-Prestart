@section('page-script')
    <script>
        $(document).ready(function() {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('shifts.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'linked_shift',
                        name: 'linked_shift'
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

            $('#addShiftBtn').on('click', function() {
                openDynamicFormModal({
                    modalId: 'addOrEditShiftModal',
                    formId: 'shiftAddForm',
                    title: 'Add a new shift',
                    action: "{{ route('shifts.store') }}",
                    method: 'POST',
                    fields: [{
                        name: 'name',
                        type: 'text',
                        placeholder: 'Enter shift name',
                        required: true,
                        label: 'Name'
                    }]
                });
                // Load linked shifts HTML separately and inject
                getAllShifts().then(response => {
                    $('.dynamic-wrapper').html(response);
                });
            });

            $('#shiftAddForm').on('submit', function(e) {
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
                        ajaxBeforeSend('#shiftAddForm', '#shiftSubmitBtn');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addOrEditShiftModal').modal('hide');
                            table.ajax.reload();
                            $('#shiftAddForm')[0].reset();
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#shiftSubmitBtn');
                    }
                });
            });

            // Reset modal when closed
            $('#addOrEditShiftModal').on('hidden.bs.modal', function() {
                $('#shiftAddForm')[0].reset();
                $('#method').val('POST');
                $('#shiftAddForm').attr('action', "{{ route('shifts.store') }}");
                $('.linked-shift-wrapper').empty();
                $('#addOrEditShiftModalLabel').text('Add a new shift');
            });

            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $('#loader').show();

                let editUrl = "{{ route('shifts.edit', ':id') }}".replace(':id', id);

                $.get(editUrl, function(data) {
                    $('#loader').hide();

                    openDynamicFormModal({
                        modalId: 'addOrEditShiftModal',
                        formId: 'shiftAddForm',
                        title: 'Edit Shift',
                        action: "{{ route('shifts.update', ':id') }}".replace(':id', id),
                        method: 'PUT',
                        fields: [{
                            label: 'Name',
                            name: 'name',
                            type: 'text',
                            required: true,
                            value: data.data.name
                        }]
                    });

                    // Load linked shifts HTML and set selected value
                    getAllShifts().then(response => {
                        $('.dynamic-wrapper').html(response);
                        $('#linked_shift_id').val(data.data.linked_shift_id);
                    });
                }).fail(function() {
                    $('#loader').hide();
                    notify('error', 'Something went wrong. Please try again.');
                });
            });


            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('shifts.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteShiftModal').modal('show');
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
                        $('#deleteShiftModal').modal('hide');
                        table.ajax.reload();
                        notify('success', response.message);
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#deleteBtn', 'Delete');
                    }
                });
            });

            function getAllShifts() {
                return $.ajax({
                    url: "{{ route('shifts.get-shift-List') }}",
                    type: 'GET',
                    success: function(response) {
                        return response;
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        notify('error', 'Failed to load shift list.');
                    }
                });
            }
        });
    </script>
@endsection
