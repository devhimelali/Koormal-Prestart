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

        function getSupervisorAndLabour() {
            $.ajax({
                url: "{{route('boards.get-supervisor-and-labour-list', ['shift_type' => $shift_type])}}",
                method: 'GET',
                success: function (response) {
                    $('#board-info').html(response);
                },
                error: handleAjaxErrors,
            });
        }

        // ============= Update Board Start  =============
        function updateBoard(step, heading = "Our Health & Safety") {
            $('#board-title').text(heading);
            $.ajax({
                url: "{{ route('boards.show.board') }}",
                method: 'POST',
                data: {
                    step: step,
                    shift_id: "{{ $shift_id }}",
                    shift_type: "{{$shift_type}}",
                    start_date: "{{$start_date}}",
                    end_date: "{{$end_date}}",
                    rotation_id: "{{$rotation_id}}",
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

        // ============= Update Board End  =============

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

        // =============  Define Audio Variables  =============
        let currentAudio = null;
        let currentIcon = null;
        let currentWrapper = null;

        let supervisorName = null;

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

            // ============= Add Blank Question Start  =============
            function addBlankQuestion(question_number, answer = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.health-safety-review') }}",
                    method: 'POST',
                    data: {
                        question_number: question_number,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
                        answer: answer,
                        date: date,
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

            // ============= Add Blank Question End  =============

            // ============= Show Already Submitted Warning Start  =============
            function showAlreadySubmittedWarning(message) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Already Submitted',
                    text: message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33',
                });
            }

            // ============= Show Already Submitted Warning End  =============

            function getTodaysDate() {
                let today = new Date();
                let day = String(today.getDate()).padStart(2, '0');
                let month = String(today.getMonth() + 1).padStart(2, '0');
                let year = today.getFullYear();
                return `${day}-${month}-${year}`;
            }

            // ============= Add Blank Health Safety Review Question One Start  =============
            $(document).on('click', '#addQuestionOneBtn', function () {
                let question_one = $('.question-one').last();

                if (question_one && question_one.text().trim() !== '' && question_one.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's health and safety review! You can only submit one health and safety review per day.");
                    return;
                } else {
                    addBlankQuestion('question_one');
                }
            });


            $(document).on('blur', '.question-one', function () {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                addBlankQuestion('question_one', answer, date);
            });
            // ============= Add Blank Health Safety Review Question One End  =============


            // ============= Add Blank Health Safety Review Question Two Start  =============
            $(document).on('click', '#addQuestionTwoBtn', function () {
                let question_two = $('.question-two').last();
                if (question_two && question_two.text().trim() !== '' && question_two.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's health and safety review! You can only submit one health and safety review per day.");
                    return;
                } else {
                    addBlankQuestion('question_two');
                }
            });

            $(document).on('blur', '.question-two', function () {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                addBlankQuestion('question_two', answer, date);
            });
            // ============= Add Blank Health Safety Review Question Two End  =============

            // ============= Health and Safety Cross Criteria Calendar Start  =============
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

            $(document).on('click', '.cross-criteria', function () {
                let cell = $(this).data('cell');
                $('#safetyCalendarModal #safetyCalendarCell').val(cell);
                $('#safetyCalendarModal #safetyCalendarStartDate').val("{{$start_date}}");
                $('#safetyCalendarModal #safetyCalendarEndDate').val("{{$end_date}}");
                $('#safetyCalendarModal #safetyCalendarShiftId').val("{{$shift_id}}");
                $('#safetyCalendarModal #safetyCalendarRotationId').val("{{$rotation_id}}");
                $('#safetyCalendarModal #safetyCalendarShiftType').val("{{$shift_type}}");
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

            // ============= Health and Safety Cross Criteria Calendar End  =============

            // ============= Productivity Review Start  =============
            function addBlankProductiveQuestion(question_number, answer = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.productive-question') }}",
                    method: 'POST',
                    data: {
                        question_number: question_number,
                        answer: answer,
                        date: date,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
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
                let question_one = $('.productivity-question-one').last();
                if (question_one && question_one.text().trim() != '' && question_one.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's productivity review! You can only submit one productivity review per day.");
                    return;
                } else {
                    addBlankProductiveQuestion('question_one');
                }
            });

            $(document).on('blur', '.productivity-question-one', function () {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                addBlankProductiveQuestion('question_one', answer, date);
            });

            $(document).on('click', '#addProductivityQuestionTwoBtn', function () {
                let question_two = $('.productivity-question-two').last();
                if (question_two && question_two.text().trim() != '' && question_two.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's productivity review! You can only submit one productivity review per day.");
                    return;
                } else {
                    addBlankProductiveQuestion('question_two');
                }
            });

            $(document).on('blur', '.productivity-question-two', function () {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                addBlankProductiveQuestion('question_two', answer, date);
            });

            // ============= Productivity Review End  =============

            // ============= Celebrate Success Start  =============
            function addBlankSuccessNote(note = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.celebrate-success') }}",
                    method: 'POST',
                    data: {
                        note: note,
                        date: date,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
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
                let note = $('.success-note').last();
                if (note && note.text().trim() != '' && note.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's celebrate success! You can only submit one celebrate success per day.");
                    return;
                } else {
                    addBlankSuccessNote();
                }
            });

            $(document).on('blur', '.success-note', function () {
                let note = $(this).text().trim();
                let date = $(this).data('date');
                addBlankSuccessNote(note, date);
            });
            // ============= Celebrate Success End  =============

            // ============= Site Communications Start  =============
            function addBlankSiteCommunication(note = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.site-communication') }}",
                    method: 'POST',
                    data: {
                        note: note,
                        date: date,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
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
                let note = $('.site-communication-note').last();
                if (note && note.text().trim() != '' && note.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's site communication! You can only submit one site communication per day.");
                    return;
                } else {
                    addBlankSiteCommunication();
                }
            });

            $(document).on('blur', '.site-communication-note', function () {
                let note = $(this).text().trim();
                let date = $(this).data('date');
                addBlankSiteCommunication(note, date);
            });
            // ============= Site Communications End  =============

            // ============= Improve our performance Start  =============
            function addBlankImprovePerformance(issues = null, who = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.improve-performance') }}",
                    method: 'POST',
                    data: {
                        issues: issues,
                        who: who,
                        date: date,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
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

            // Add new blank performance entry
            $(document).on('click', '#addImprovePerformanceBtn', function () {
                let issuesEl = $('.issues').last();
                if (issuesEl.length && issuesEl.text().trim() != '' && issuesEl.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's improve our performance! You can only submit one improve our performance per day.");
                    return;
                }
                addBlankImprovePerformance();
            });

            // Save changes on blur
            $(document).on('blur', '.issues, .who', function () {
                let row = $(this).closest('tr');
                let issues = row.find('.issues').text().trim();
                let who = row.find('.who').text().trim();
                let date = row.find('.issues').data('date');
                addBlankImprovePerformance(issues, who, date);
            });
            // ============= Improve our performance End  =============

            // ============= Health and safety focus Start  =============
            function addBlankHealthAndSafety(note = null, date = null) {
                $.ajax({
                    url: "{{ route('boards.store.health-safety-focus') }}",
                    method: 'POST',
                    data: {
                        note: note,
                        date: date,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
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

            // Add new blank performance entry
            $(document).on('click', '#addSafetyFocusBtn', function () {
                let noteEl = $('.safety-focus').last();
                if (noteEl.length && noteEl.text().trim() != '' && noteEl.data('date') === getTodaysDate()) {
                    showAlreadySubmittedWarning("You have already submitted today's health and safety focus! You can only submit one health and safety focus per day.");
                    return;
                }
                addBlankHealthAndSafety();
            });

            // Save changes on blur
            $(document).on('blur', '.safety-focus', function () {
                let row = $(this).closest('tr');
                let note = row.find('.safety-focus').text().trim();
                let date = row.find('.safety-focus').data('date');
                addBlankHealthAndSafety(note, date);
            });
            // ============= Health and safety focus End  =============
            // ============= Fatal risk to discuss start  =============
            $(document).on('click', '.risk-card', function () {
                $(this).addClass('selected-risk');

                let riskId = $(this).data('risk-id');
                let riskName = $(this).find('h6').text();
                let riskImage = $(this).find('img').attr('src');

                $.ajax({
                    url: "{{ route('get-control-list-for-fatal-risk-to-discuss') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        risk_id: riskId,
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        $('#controlListModal .modal-title').html(`
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <img src="${riskImage}" alt="${riskName}" width="35"
                                 class="img-fluid">
                        </div>
                        <div>
                            <h5 class="mb-0">${riskName}</h5>
                        </div>
                    </div>
                `);
                        $('#controlListModal .modal-body').html(response);
                        new Choices("#control", {
                            removeItemButton: true,
                            searchEnabled: true
                        });
                        $('#controlListModal').modal('show');
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                })
            });

            $(document).on('change', '#control', function () {
                $('#discussNoteDiv').removeClass('d-none');
            });

            $(document).on('submit', '#controlListForm', function (e) {
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
                        ajaxBeforeSend('#controlListForm',
                            '#controlListSubmitBtn');
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#controlListModal').modal('hide');
                            notify('success', response.message);
                            setTimeout(() => {
                                updateBoard(response.step);
                            }, 500);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        ajaxComplete('#controlListSubmitBtn', 'Save');
                    }
                })
            });

            $(document).on('hidden.bs.modal', '#controlListModal', function () {
                if (typeof updateBoard === 'function') {
                    updateBoard(10, 'Pick a Fatal Risk to discuss');
                }
            });

            $(document).on('click', '#viewAllDiscussListBtn', function () {
                $.ajax({
                    url: "{{ route('boards.view-all-discuss-list') }}",
                    method: 'GET',
                    data: {
                        shift_id: "{{$shift_id}}",
                        shift_rotation_id: "{{$rotation_id}}",
                        start_date: "{{$start_date}}",
                        end_date: "{{$end_date}}",
                        shift_type: "{{$shift_type}}",
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (response) {
                        $('#viewAllDiscussListModal .modal-body').html(response);
                        $('#viewAllDiscussListModal').modal('show');

                    },
                    error: handleAjaxErrors,
                    complete: function () {
                        $('#loader').hide();
                    }
                })
            })

            $(document).on('click', '#deleteTodayDiscussListBtn', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete all entries made today. This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reset today’s entries!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('boards.delete-today-discuss-list') }}",
                            method: 'POST',
                            data: {
                                shift_id: "{{$shift_id}}",
                                shift_rotation_id: "{{$rotation_id}}",
                                start_date: "{{$start_date}}",
                                end_date: "{{$end_date}}",
                                shift_type: "{{$shift_type}}",
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function () {
                                $('#loader').show();
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    notify('success', response.message);
                                    setTimeout(() => {
                                        updateBoard(response.step);
                                    }, 500);
                                }
                            },
                            error: handleAjaxErrors,
                            complete: function () {
                                $('#loader').hide();
                            }
                        })
                    }
                })
            })

            function loadSupervisorAndLabourName()
            {
                $.ajax({
                    url: "{{ route('boards.load-supervisor-and-labour-name') }}",
                    method: 'GET',
                    data: {
                        shift_type: "{{$shift_type}}",
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#supervisor-name').text(response.supervisor_name);
                        $('#labour-name').text(response.labor_name);
                    }
                });
            }

            loadSupervisorAndLabourName();

            setInterval(loadSupervisorAndLabourName, 30000);
        });
    </script>
@endsection
