@section('page-script')
    <script>
        $(document).ready(function() {
            let table = $('#fatalityRiskControlsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('fatality-risk-controls.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    }, {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#addFatalityRiskControlForm').submit(function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        ajaxBeforeSend('#addFatalityRiskControlForm',
                            '#addFatalityRiskControlSubmitBtn');
                    },
                    success: function(response) {
                        table.ajax.reload();
                        notify('success', response.message);
                        $('#addFatalityRiskControlForm')[0].reset();
                        resetCkEditors();
                        $('#old-image-preview').addClass('d-none');
                        document.querySelectorAll('.dropzone[data-input-id]').forEach(
                            dropzone => {
                                const id = dropzone.dataset.inputId;
                                const preview = document.getElementById(`preview-${id}`);
                                if (preview) preview.innerHTML = '';
                            });
                        $('#addFatalityRiskControlModal').modal('hide');
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#addFatalityRiskControlSubmitBtn', 'Save');
                    }
                });
            });

            // Reset CKEditor and form when modal closes
            $('#addFatalityRiskControlModal').on('hidden.bs.modal', function() {
                $('#method').val('POST');
                $('#addFatalityRiskControlForm').attr('action',
                    "{{ route('fatality-risk-controls.store') }}");
                $('#addFatalityRiskControlModal .modal-title').text('Add a new fatality risk control');
                $('.invalid-feedback').text('').removeClass('d-block');
                $('#addFatalityRiskControlForm')[0].reset();
                resetCkEditors();
            });

            $(document).on('click', '.edit', function() {
                let id = $(this).data('id');
                $('#loader').show();
                let editUrl = "{{ route('fatality-risk-controls.edit', ':id') }}".replace(':id', id);
                $.get(editUrl, function(response) {
                    $('#loader').hide();
                    $('#addFatalityRiskControlModal .modal-title').text(
                        'Edit fatality risk control');
                    $('#method').val('PUT');
                    $('#addFatalityRiskControlForm').attr('action',
                        "{{ route('fatality-risk-controls.update', ':id') }}"
                        .replace(':id', id));
                    $('#addFatalityRiskControlForm #name').val(response.data.name);
                    //show description in CKEditor
                    if (window.editors && window.editors['description']) {
                        window.editors['description'].setData(response.data.description || '');
                    }
                    $('#old-image-preview').html('<img src="' + getImageUrl(response.data.image) +
                        '" alt="Old Image" width="100" height="100">');
                    $('#old-image-preview').removeClass('d-none');

                    $('#addFatalityRiskControlModal').modal('show');
                });
            })

            function getImageUrl(path) {
                return "{{ asset('storage') }}/" + path;
            }

            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('fatality-risk-controls.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteFatalityRiskControlModal').modal('show');
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
                        $('#deleteFatalityRiskControlModal').modal('hide');
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
