@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateBoard(step, heading = "Our Health & Safety", $shift_id = {{ $dailyShiftEntry->shift_id }},
            $rotation_id = {{ $dailyShiftEntry->shift_rotation_id }}, $shift_type = "{{ $dailyShiftEntry->shift_type }}"
        ) {
            $('#board-title').text(heading);
            $.ajax({
                url: "{{ route('boards.show.board') }}",
                method: 'POST',
                data: {
                    step: step,
                    daily_shift_entry_id: {{ $dailyShiftEntry->id }},
                    shift_id: $shift_id,
                    rotation_id: $rotation_id,
                    shift_type: $shift_type,
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

            $(document).on('click', '#addProductivityQuestionOneBtn', function() {
                let daily_shift_entry_id = {{ $dailyShiftEntry->id }};
                let answer = $('.productivity-question-one').text().trim();
                addBlankProductiveQuestion('question_one', daily_shift_entry_id, answer);
            });

            $(document).on('click', '#addProductivityQuestionTwoBtn', function() {
                let daily_shift_entry_id = {{ $dailyShiftEntry->id }};
                let answer = $('.productivity-question-two').text().trim();
                addBlankProductiveQuestion('question_two', daily_shift_entry_id, answer);
            });

            $(document).on('blur', '.productivity-question-one', function() {
                let answer = $(this).text().trim();
                addBlankProductiveQuestion('question_one', {{ $dailyShiftEntry->id }}, answer);
            });

            $(document).on('blur', '.productivity-question-two', function() {
                let answer = $(this).text().trim();
                addBlankProductiveQuestion('question_two', {{ $dailyShiftEntry->id }}, answer);
            });

            function addBlankProductiveQuestion(question_number, daily_shift_entry_id = {{ $dailyShiftEntry->id }},
                answer =
                null) {
                $.ajax({
                    url: "{{ route('boards.store.productive-question') }}",
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

            $(document).on('click', '#addSuccessNoteBtn', function() {
                let note = $('.success-note').text().trim();
                addBlankSuccessNote(note);
            });

            $(document).on('blur', '.success-note', function() {
                let note = $(this).text().trim();
                addBlankSuccessNote(note);
            });

            function addBlankSuccessNote(note =
                null, daily_shift_entry_id = {{ $dailyShiftEntry->id }}
            ) {
                $.ajax({
                    url: "{{ route('boards.store.celebrate-success') }}",
                    method: 'POST',
                    data: {
                        daily_shift_entry_id: daily_shift_entry_id,
                        note: note,
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

            $(document).on('click', '#addSiteCommunicationBtn', function() {
                let note = $('.site-communication-note').text().trim();
                addBlankSiteCommunication(note);
            });

            $(document).on('blur', '.site-communication-note', function() {
                let note = $(this).text().trim();
                addBlankSiteCommunication(note);
            });

            function addBlankSiteCommunication(note =
                null, daily_shift_entry_id = {{ $dailyShiftEntry->id }}
            ) {
                $.ajax({
                    url: "{{ route('boards.store.site-communication') }}",
                    method: 'POST',
                    data: {
                        daily_shift_entry_id: daily_shift_entry_id,
                        note: note,
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
            });


            $(document).on('click', '.criteria-option', function() {
                let $clicked = $(this);
                let $option = $clicked.find('.option');
                let criteriaId = $clicked.data('id');

                // Set hidden input value
                $('#safetyCalendarModal #safetyCalendarCriteriaId').val(criteriaId);

                // Deselect all other options
                $('.criteria-option').each(function() {
                    let $item = $(this);
                    let color = $item.data('color');
                    let bg = $item.data('bg');
                    $item.find('.option')
                        .removeClass('selected')
                        .css({
                            border: `${color} 2px solid`,
                            backgroundColor: bg
                        });
                });

                // Select the clicked one
                $option.addClass('selected').css({
                    border: '2px solid #000',
                    backgroundColor: '#f0f0f0'
                });
            });

            $(document).on('submit', '#safetyCalendarForm', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        ajaxBeforeSend('#safetyCalendarForm', '#safetyCalendarSubmitBtn')
                    },
                    success: function(response) {
                        notify('success', response.message);
                        $('#safetyCalendarModal').modal('hide');
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#safetyCalendarSubmitBtn');
                    }
                });
            });

            $(document).on('click', '#resetLegendBtn', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will reset the safety calendar to its default state.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reset it!',
                    confirmButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('boards.reset.safety-calendar') }}",
                            method: 'POST',
                            data: {
                                daily_shift_entry_id: {{ $dailyShiftEntry->id }},
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
            });

        });
    </script>
@endsection
