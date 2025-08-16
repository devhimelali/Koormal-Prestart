@section('page-script')
    <script>
        $(document).ready(function () {
            let table = $('#fatalityControlsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('fatality-controls.index') }}",
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

            function getAllFatalityRisks(preselectedId = null) {
                return $.ajax({
                    url: "{{ route('fatality-risks.get-list') }}",
                    type: 'GET',
                    success: function (response) {
                        const $select = $('#fatality_risk_id');
                        $select.empty();
                        $select.append(`<option value="">Select a Fatality Risk</option>`);

                        response.data.forEach(function (risk) {
                            const selected = risk.id == preselectedId ? 'selected' : '';
                            $select.append(
                                `<option value="${risk.id}" ${selected}>${risk.name}</option>`
                            );
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        notify('error', 'Failed to load fatality risk list.');
                    }
                });
            }

            $(document).on('click', '#addFatalityControlBtn', function () {
                getAllFatalityRisks()
                $('#addFatalityControlModal').modal('show');
            })

            $('#addFatalityControlForm').submit(function (e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        ajaxBeforeSend('#addFatalityControlForm',
                            '#addFatalityControlSubmitBtn');
                    },
                    success: function (response) {
                        table.ajax.reload();
                        notify('success', response.message);
                        $('#addFatalityControlForm')[0].reset();
                        resetCkEditors();
                        document.querySelectorAll('.dropzone[data-input-id]').forEach(
                            dropzone => {
                                const id = dropzone.dataset.inputId;
                                const preview = document.getElementById(`preview-${id}`);
                                if (preview) preview.innerHTML = '';
                            });
                        $('#addFatalityControlModal').modal('hide');
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        ajaxComplete('#addFatalityControlSubmitBtn', 'Save');
                    }
                });
            });

            // Reset CKEditor and form when modal closes
            $('#addFatalityControlModal').on('hidden.bs.modal', function () {
                $('#method').val('POST');
                $('#addFatalityControlForm').attr('action',
                    "{{ route('fatality-controls.store') }}");
                $('#addFatalityControlModal .modal-title').text('Add a new fatality control');
                $('.invalid-feedback').text('').removeClass('d-block');
                $('#addFatalityControlForm')[0].reset();
                resetCkEditors();
            });

            $(document).on('click', '.edit', function () {
                let id = $(this).data('id');
                $('#loader').show();
                let editUrl = "{{ route('fatality-controls.edit', ':id') }}".replace(':id', id);
                $.get(editUrl, function (response) {
                    $('#loader').hide();
                    $('#addFatalityControlModal .modal-title').text(
                        'Edit fatality control');
                    $('#method').val('PUT');
                    $('#addFatalityControlForm').attr('action',
                        "{{ route('fatality-controls.update', ':id') }}"
                            .replace(':id', id));
                    getAllFatalityRisks(response.data.fatality_risk_id);
                    //show description in CKEditor
                    $('#addFatalityControlForm #description').val(response.data.description);
                    $('#addFatalityControlModal').modal('show');
                });
            })

            $('body').on('click', '.delete', function () {
                let id = $(this).data('id');
                let deleteUrl = "{{ route('fatality-controls.destroy', ':id') }}".replace(':id', id);
                $('#deleteForm').attr('action', deleteUrl);
                $('#deleteFatalityRiskModal').modal('show');
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
                        $('#deleteFatalityRiskModal').modal('hide');
                        table.ajax.reload();
                        notify('success', response.message);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        ajaxComplete('#deleteBtn', 'Delete');
                    }
                });
            });
        });
    </script>
@endsection
