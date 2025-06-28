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
                $.ajax({
                    url: "{{ route('shifts.get-shift-List') }}",
                    type: 'GET',
                    success: function(response) {
                        $('.linked-shift-wrapper').html(response);
                        $('#addOrEditShiftModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endsection
