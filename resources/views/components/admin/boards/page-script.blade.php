@section('page-script')
    <script>
        $(document).ready(function() {
            $(document).on('blur', '.supervisor-name', function() {
                supervisorName = $(this).text().trim();
                $.ajax({
                    url: "{{ route('boards.updateSupervisorName') }}",
                    method: 'POST',
                    data: {
                        supervisor_name: supervisorName,
                        daily_shift_entry_id: {{ $dailyShiftEntry->id }},
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        $('#loader').hide();
                    }
                })
            });

            let currentStep = 1;
            $.ajax({
                url: "{{ route('boards.show.board') }}",
                method: 'POST',
                data: {
                    step: currentStep,
                    daily_shift_entry_id: {{ $dailyShiftEntry->id }},
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    console.log(response);
                    $('#board-container').html(response);
                },
                error: handleAjaxErrors,
                complete: function() {
                    $('#loader').hide();
                }
            })
        })
    </script>
@endsection
