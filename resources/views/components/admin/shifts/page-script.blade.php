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
                getAllShifts();
                $('#addOrEditShiftModal').modal('show');
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

            $('#addOrEditShiftModal').on('hidden.bs.modal', function() {
                $('#shiftAddForm')[0].reset();
                $('#method').val('POST');
                $('#shiftAddForm').attr('action', "{{ route('shifts.store') }}");
                $('.linked-shift-wrapper').empty();
                $('#addOrEditShiftModalLabel').text('Add a new shift');
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');

                $('#loader').show();

                getAllShifts().then(function() {
                    var editUrl = "{{ route('shifts.edit', ':id') }}".replace(':id', id);

                    $.get(editUrl, function(data) {
                        $('#loader').hide();

                        $('#addOrEditShiftModal .modal-title').text('Edit Shift');
                        $('#shiftAddForm').attr('action',
                            "{{ route('shifts.update', ':id') }}".replace(':id', id)
                        );
                        $('#method').val('PUT');
                        $('#name').val(data.data.name);
                        $('#linked_shift_id').val(data.data.linked_shift_id);

                        $('#addOrEditShiftModal').modal('show');
                    }).fail(function() {
                        $('#loader').hide();
                        notify('error', 'Something went wrong. Please try again.');
                    });
                });
            });

            function getAllShifts() {
                return $.ajax({
                    url: "{{ route('shifts.get-shift-List') }}",
                    type: 'GET',
                    success: function(response) {
                        $('.linked-shift-wrapper').html(response);
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
