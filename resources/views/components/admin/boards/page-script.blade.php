@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- GLightbox Script -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // ============= GLightbox Init Start  =============
        let lightboxInstance;

        function initGlightbox() {
            if (lightboxInstance && typeof lightboxInstance.destroy === 'function') {
                lightboxInstance.destroy();
            }

            lightboxInstance = GLightbox({
                selector: '.glightbox'
            });
        }

        document.addEventListener('DOMContentLoaded', initGlightbox);
        // ============= GLightbox Init End  =============

        {{--function getSupervisorAndLabour() {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{route('boards.get-supervisor-and-labour-list', $d)}}",--}}
        {{--        method: 'GET',--}}
        {{--        success: function (response) {--}}
        {{--            $('#board-info').html(response);--}}
        {{--        },--}}
        {{--        error: handleAjaxErrors,--}}
        {{--    });--}}
        {{--}--}}

        function updateBoard(step, heading = "Our Health & Safety", shift_id = "{{$shift_id}}", shift_type = "{{$shift_type}}", start_date = "{{$start_date}}", end_date = "{{$end_date}}") {
            $('#board-title').text(heading);
            $.ajax({
                url: "{{ route('boards.show.board') }}",
                method: 'POST',
                data: {
                    step: step,
                    shift_id: shift_id,
                    shift_type: shift_type,
                    start_date: start_date,
                    end_date: end_date,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#loader').show();
                },
                success: function (response) {
                    $('#board-container').html(response);
                    initGlightbox();
                },
                error: handleAjaxErrors,
                complete: function () {
                    $('#loader').hide();
                }
            })
        }

        $(document).on('submit', '#fatalityRiskControlForm', function (e) {
            e.preventDefault();
            let form = $(this);
            let data = form.serialize();
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: data,
                beforeSend: function () {
                    ajaxBeforeSend('#fatalityRiskControlForm', '#fatalityRiskControlSubmitBtn');
                },
                success: function (response) {
                    $('#loader').hide();
                    if (response.status == 'success') {
                        notify('success', response.message);
                        $('#board-header').removeClass('mb-3');
                        $('#board-header').addClass('mb-1');
                        $('#board-info').removeClass('d-none');
                        $('#fatalityRiskControlModal').modal('hide');
                        setTimeout(() => {
                            updateBoard(response.step, "Fatality Risk Management (FRM) Job Risk Control Board");
                        }, 1500);
                        getSupervisorAndLabour();
                    }
                },
                error: handleAjaxErrors,
                complete: function () {
                    ajaxComplete('#fatalityRiskControlSubmitBtn', 'Save');

                }
            });
        });


        let currentAudio = null;
        let currentIcon = null;
        let currentWrapper = null;

        $(document).ready(function () {
            $(document).on('blur', '.supervisor-name', function () {
                supervisorName = $(this).text().trim();
                $.ajax({
                    url: "{{ route('boards.updateSupervisorName') }}",
                    method: 'POST',
                    data: {
                        supervisor_name: supervisorName,
                        daily_shift_entry_id: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                })
            });

            let currentStep = 1;

            updateBoard(currentStep);


            $(document).on('click', '#addQuestionOneBtn', function () {
                let daily_shift_entry_id = 1;
                addBlankQuestion('question_one', daily_shift_entry_id);
            });

            $(document).on('click', '#addQuestionTwoBtn', function () {
                let daily_shift_entry_id = 1;
                addBlankQuestion('question_two', daily_shift_entry_id);
            });

            $(document).on('blur', '.question-one', function () {
                let answer = $(this).text().trim();
                addBlankQuestion('question_one', 1, answer);
            });

            $(document).on('blur', '.question-two', function () {
                let answer = $(this).text().trim();
                addBlankQuestion('question_two', 1, answer);
            });

            function addBlankQuestion(question_number, daily_shift_entry_id = 1, answer =
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
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        notify('success', response.message);
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                });
            }

            $(document).on('click', '#addProductivityQuestionOneBtn', function () {
                let daily_shift_entry_id = 1;
                addBlankProductiveQuestion('question_one', daily_shift_entry_id);
            });

            $(document).on('click', '#addProductivityQuestionTwoBtn', function () {
                let daily_shift_entry_id = 1;
                addBlankProductiveQuestion('question_two', daily_shift_entry_id);
            });

            $(document).on('blur', '.productivity-question-one', function () {
                let answer = $(this).text().trim();
                addBlankProductiveQuestion('question_one', 1, answer);
            });

            $(document).on('blur', '.productivity-question-two', function () {
                let answer = $(this).text().trim();
                addBlankProductiveQuestion('question_two', 1, answer);
            });

            function addBlankProductiveQuestion(question_number, daily_shift_entry_id = 1,
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
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        notify('success', response.message);
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                });
            }

            $(document).on('click', '#addSuccessNoteBtn', function () {
                addBlankSuccessNote();
            });

            $(document).on('blur', '.success-note', function () {
                let note = $(this).text().trim();
                addBlankSuccessNote(note);
            });

            function addBlankSuccessNote(note =
                                         null, daily_shift_entry_id = 1
            ) {
                $.ajax({
                    url: "{{ route('boards.store.celebrate-success') }}",
                    method: 'POST',
                    data: {
                        daily_shift_entry_id: daily_shift_entry_id,
                        note: note,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        notify('success', response.message);
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                });
            }

            $(document).on('click', '#addSiteCommunicationBtn', function () {
                addBlankSiteCommunication();
            });

            $(document).on('blur', '.site-communication-note', function () {
                let note = $(this).text().trim();
                addBlankSiteCommunication(note);
            });

            function addBlankSiteCommunication(note =
                                               null, daily_shift_entry_id = 1
            ) {
                $.ajax({
                    url: "{{ route('boards.store.site-communication') }}",
                    method: 'POST',
                    data: {
                        daily_shift_entry_id: daily_shift_entry_id,
                        note: note,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        notify('success', response.message);
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                });
            }

            $(document).on('click', '.legend-item', function () {
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

            $(document).on('click', '.calendar-cell', function () {
                let cell = $(this).data('cell');
                $('#safetyCalendarModal #safetyCalendarCell').val(cell);
                $('#safetyCalendarModal').modal('show');
            });


            $(document).on('click', '.criteria-option', function () {
                let $clicked = $(this);
                let $option = $clicked.find('.option');
                let criteriaId = $clicked.data('id');

                // Set hidden input value
                $('#safetyCalendarModal #safetyCalendarCriteriaId').val(criteriaId);

                // Deselect all other options
                $('.criteria-option').each(function () {
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

            $(document).on('submit', '#safetyCalendarForm', function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    beforeSend: function () {
                        ajaxBeforeSend('#safetyCalendarForm', '#safetyCalendarSubmitBtn')
                    },
                    success: function (response) {
                        notify('success', response.message);
                        $('#safetyCalendarModal').modal('hide');
                        setTimeout(() => {
                            updateBoard(response.step);
                        }, 500);
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        ajaxComplete('#safetyCalendarSubmitBtn');
                    }
                });
            });

            $(document).on('click', '#resetLegendBtn', function () {
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
                                daily_shift_entry_id: 1,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function () {
                                $('#loader').show();
                            },
                            success: function (response) {
                                notify('success', response.message);
                                setTimeout(() => {
                                    updateBoard(response.step);
                                }, 500);
                            },
                            error: handleAjaxErrors,
                            complete: function () {
                                $('#loader').hide();
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
