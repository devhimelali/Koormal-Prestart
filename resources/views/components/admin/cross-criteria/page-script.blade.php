@section('page-script')
    <script>
        let ckeditorInstance;

        $(document).ready(function() {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('cross-criteria.index') }}",
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
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'description',
                        name: 'description'
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

            // Initialize CKEditor 5
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    ckeditorInstance = editor;
                })
                .catch(error => {
                    console.error(error);
                });


            // Form submit handler
            $('#addOrEditForm').submit(function(e) {
                e.preventDefault();
                // Get CKEditor data and sync it to the textarea
                $('#description').val(ckeditorInstance.getData());
                const formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        ajaxBeforeSend('#addOrEditForm', '#addOrEditSubmitBtn');
                    },
                    success: function(response) {
                        $('#addOrEditModal').modal('hide');
                        table.ajax.reload();
                        notify('success', response.message);
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#addOrEditSubmitBtn', 'Save');
                    }
                });
            });

            // Reset CKEditor and form when modal closes
            $('#addOrEditModal').on('hidden.bs.modal', function() {
                $('#method').val('POST');
                $('#addOrEditForm').attr('action', "{{ route('cross-criteria.store') }}");
                $('#addOrEditModal .modal-title').text('Add a new cross criteria');
                $('.invalid-feedback').text('').removeClass('d-block');
                $('#addOrEditForm')[0].reset();
                if (ckeditorInstance) {
                    ckeditorInstance.setData('');
                }
            });

            $(document).on('click', '.edit', function() {
                let id = $(this).data('id');
                $('#loader').show();
                let editUrl = "{{ route('cross-criteria.edit', ':id') }}".replace(':id', id);
                $.get(editUrl, function(response) {
                    $('#loader').hide();
                    $('#addOrEditModal .modal-title').text('Edit cross criteria');
                    $('#method').val('PUT');
                    $('#addOrEditForm').attr('action', "{{ route('cross-criteria.update', ':id') }}"
                        .replace(':id', id));
                    $('#addOrEditForm #name').val(response.data.name);
                    $('#addOrEditForm #color').val(response.data.color);
                    //show description in CKEditor
                    if (ckeditorInstance) {
                        ckeditorInstance.setData(response.data.description);
                    }
                    $('#addOrEditModal').modal('show');
                });
            })

            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('cross-criteria.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteCrossCriteriaModal').modal('show');
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
                        $('#deleteCrossCriteriaModal').modal('hide');
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
