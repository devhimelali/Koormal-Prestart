@section('page-script')
    <script>
        function updateBoard(step, heading = "Our Health & Safety") {
            $('#board-title').text(heading);
            $.ajax({
                url: "{{ route('boards.show.board') }}",
                method: 'POST',
                data: {
                    step: step,
                    daily_shift_entry_id: {{ $dailyShiftEntry->id }},
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#board-container').html(response);
                },
                error: handleAjaxErrors,
                complete: function() {
                    $('#loader').hide();
                }
            })
        }


        let currentAudio = null;
        let currentIcon = null;
        let currentWrapper = null;

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

            updateBoard(currentStep);


            $(document).on('click', '#addQuestionOneBtn', function() {
                let daily_shift_entry_id = {{ $dailyShiftEntry->id }};
                addBlankQuestion('question_one', daily_shift_entry_id);
            });

            $(document).on('click', '#addQuestionTwoBtn', function() {
                let daily_shift_entry_id = {{ $dailyShiftEntry->id }};
                addBlankQuestion('question_two', daily_shift_entry_id);
            });

            $(document).on('blur', '.question-one', function() {
                let answer = $(this).text().trim();
                addBlankQuestion('question_one', {{ $dailyShiftEntry->id }}, answer);
            });

            $(document).on('blur', '.question-two', function() {
                let answer = $(this).text().trim();
                addBlankQuestion('question_two', {{ $dailyShiftEntry->id }}, answer);
            });

            function addBlankQuestion(question_number, daily_shift_entry_id = {{ $dailyShiftEntry->id }}, answer =
                null) {
                $.ajax({
                    url: "{{ route('boards.store.health-safety-review') }}",
                    method: 'POST',
                    data: {
                        daily_shift_entry_id: daily_shift_entry_id,
                        question_number: question_number,
                        answer: answer,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
                        notify('success', response.message);
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            }
        });
    </script>
@endsection
