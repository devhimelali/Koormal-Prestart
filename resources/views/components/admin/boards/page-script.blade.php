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

            $(document).on('click', '.legend-item', function() {
                let name = $(this).data('name');
                let color = $(this).data('color');
                let bg_color = $(this).data('bg-color');
                let description = $(this).data('description');
                $('#crossCriteriaViewModal .cross-criteria-title').text(name);
                $('#crossCriteriaViewModal .cross-criteria-content').html(`
                <div style="border: ${color} 2px solid; background-color: ${bg_color};padding: 10px; border-radius: 5px;">
                    ${description}
                    </div>
                `);
                $('#crossCriteriaViewModal').modal('show');
            });

            $(document).on('click', '.calendar-cell', function() {
                let cell = $(this).data('cell');
                $('#safetyCalendarModal #safetyCalendarCell').val(cell);
                $('#safetyCalendarModal').modal('show');
            })

            $(document).on('click', '.criteria-option', function() {
                let $clicked = $(this);
                let $option = $clicked.find('.option');
                let criteriaId = $clicked.data('id');
                $('#safetyCalendarModal #safetyCalendarCriteriaId').val(criteriaId);

                // Restore all others to original style
                $('.criteria-option').each(function() {
                    let $item = $(this);
                    if ($item[0] !== $clicked[0]) {
                        let color = $item.data('color');
                        let bg = $item.data('bg');
                        $item.find('.option')
                            .removeClass('selected')
                            .css({
                                border: `${color} 2px solid`,
                                backgroundColor: bg
                            });
                    }
                });

                // Toggle selected state on clicked
                if ($option.hasClass('selected')) {
                    // If already selected, unselect and restore original style
                    let color = $clicked.data('color');
                    let bg = $clicked.data('bg');
                    $option.removeClass('selected').css({
                        border: `${color} 2px solid`,
                        backgroundColor: bg
                    });
                } else {
                    // Select and apply selected style
                    $option.addClass('selected').css({
                        border: '2px solid #000', // or any selected style
                        backgroundColor: '#f0f0f0' // selected background
                    });
                }
            });

        });
    </script>
@endsection
