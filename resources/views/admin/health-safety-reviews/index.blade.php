@extends('layouts.app')
@section('title', 'Health Safety Review')
@section('content')
    @php
        $start_date = request('start_date');
        $end_date = request('end_date');
        $crew = request('crew');
        $shift = request('shift');
        function dateRangeBetween($startDate, $endDate)
        {
            $dates = [];
            $currentDate = \Carbon\Carbon::parse($startDate);
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->format('d-m-Y');
                $currentDate->addDay();
            }
            return $dates;
        }
        $dateArrayBetween = dateRangeBetween($start_date, $end_date);
    @endphp
    <x-common.breadcrumb :title="'Our Health & Safety List'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Our Health & Safety List']]" />
    <div class="row">
        <div class="col-12 mx-auto bg-white p-3 mb-4 border rounded shadow-sm text-center">
            <h4 class="mb-1 d-flex align-items-center justify-content-center gap-2">
                Supervisor Name:
                <span contenteditable="true" class="d-inline-block supervisor-name"
                    style="border: 1px solid #ccc; padding: 4px 8px; min-width: 250px; width: 250px; border-radius: 4px; background-color: #f9f9f9;">
                    {{ $healthSafetyReviews['supervisor_name'] }}
                </span>
            </h4>
            <p class="mb-0 text-secondary" style="font-size: 16px;">Date: <strong>{{ $start_date }}</strong> to
                <strong>{{ $end_date }}</strong>
            </p>
            <p class="mb-0 text-secondary" style="font-size: 16px;">Shift: <strong>{{ ucfirst($shift) }}</strong></p>
            <p class="mb-0 text-secondary" style="font-size: 16px;">Crew: <strong>{{ ucfirst($crew) }}</strong></p>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="card-title mb-0">Our Health & Safety</h4>
                </div>
                <div class="card-body">
                    <div class="board-container">
                        <div class="board">
                            <!-- Header with Logos and Title -->
                            <div class="row align-items-center board-header mb-3">
                                <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
                                    <img src="{{ asset('assets/logos/4emus-logo.png') }}"
                                        class="img-fluid header-logo float-start">
                                </div>
                                <div class="col-8 col-md-8 text-center">
                                    <h5 class="board-title mb-1">Review of Health & Safety</h5>
                                </div>
                                <div class="col-2 col-md-2 text-end text-md-center">
                                    <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                        class="img-fluid header-logo float-end">
                                </div>
                            </div>

                            <!-- Question 1 -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h6 class="mb-2 mb-md-0">Question 1 - What did we do to work more safely or improve our
                                    health on our last shift? <span class="play-icon"
                                        data-audio="{{ asset('assets/audios/our-health-safety/question-one.mp3') }}">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1phnduy" focusable="false"
                                            aria-hidden="true" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2M9.5 16.5v-9l7 4.5z">
                                            </path>
                                        </svg>
                                    </span></h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <tbody>
                                        @forelse ($dateArrayBetween as $date)
                                            <tr class="align-middle">
                                                <td class="bg-light text-nowrap w-50 w-md-auto" style="min-width: 100px;">
                                                    {{ $date }}
                                                    ({{ \Carbon\Carbon::parse($date)->format('l') }})
                                                </td>
                                                <td class="p-1 align-top">
                                                    <div contenteditable="true" class="question-one"
                                                        data-date="{{ $date }}"
                                                        style="
            border: 1px solid #ccc;
                 padding: 6px 8px;
                 min-height: 25px;
                 width: 100%;
                 box-sizing: border-box;
                 word-break: break-word;
                 overflow-wrap: break-word;
                 white-space: normal;
                 background-color: #fff;
                 border-radius: 4px;
        ">
                                                        {{ $healthSafetyReviews['question_1'][$date] ?? '' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Question 2 -->
                            <div class="mt-4 mb-2">
                                <h6>Question 2 - What wasn’t as healthy or safe as it should have been on our last
                                    shift?<span class="play-icon"
                                        data-audio="{{ asset('assets/audios/our-health-safety/question-two.mp3') }}">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1phnduy" focusable="false"
                                            aria-hidden="true" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2M9.5 16.5v-9l7 4.5z">
                                            </path>
                                        </svg>
                                    </span>
                                </h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <tbody>
                                        @forelse ($dateArrayBetween as $date)
                                            <tr class="align-middle">
                                                <td class="bg-light text-nowrap w-50 w-md-auto" style="min-width: 100px;">
                                                    {{ $date }}
                                                    ({{ \Carbon\Carbon::parse($date)->format('l') }})
                                                </td>
                                                <td class="p-1 align-top">
                                                    <div contenteditable="true" class="question-two"
                                                        data-date="{{ $date }}"
                                                        style="
            border: 1px solid #ccc;
                 padding: 6px 8px;
                 min-height: 25px;
                 width: 100%;
                 box-sizing: border-box;
                 word-break: break-word;
                 overflow-wrap: break-word;
                 white-space: normal;
                 background-color: #fff;
                 border-radius: 4px;
        ">

                                                        {{ $healthSafetyReviews['question_2'][$date] ?? '' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <audio id="myAudio" src=""></audio>
    @include('components.admin.health-safety-review.modals.add-or-edit-modal')
@endsection
@section('page-script')
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            flatpickr("#date", {
                dateFormat: "d-m-Y",
                maxDate: "today",
                defaultDate: "today"
            });

            $('#addOrEditOffCanvas').on('hidden.bs.offcanvas', function() {
                $('#addOrEditForm')[0].reset();
            });

            let currentAudio = null;
            let currentIcon = null;
            let currentWrapper = null;

            $('.play-icon').on('click', function() {
                let $iconWrapper = $(this);
                let $icon = $iconWrapper.find('i');
                let audioSrc = $iconWrapper.data('audio');

                // Stop current audio if playing something else
                if (currentAudio && currentAudio.src !== audioSrc) {
                    currentAudio.pause();
                    currentAudio.currentTime = 0;

                    if (currentIcon) {
                        currentIcon.removeClass('ph-pause-circle').addClass('ph-play-circle');
                    }
                    if (currentWrapper) {
                        currentWrapper.removeClass('active');
                    }
                }

                if (!currentAudio || currentAudio.src !== audioSrc) {
                    currentAudio = new Audio(audioSrc);
                    currentIcon = $icon;
                    currentWrapper = $iconWrapper;

                    currentAudio.play();
                    $icon.removeClass('ph-play-circle').addClass('ph-pause-circle');
                    $iconWrapper.addClass('active');
                } else if (!currentAudio.paused) {
                    currentAudio.pause();
                    $icon.removeClass('ph-pause-circle').addClass('ph-play-circle');
                    $iconWrapper.removeClass('active');
                } else {
                    currentAudio.play();
                    $icon.removeClass('ph-play-circle').addClass('ph-pause-circle');
                    $iconWrapper.addClass('active');
                }

                currentAudio.onended = function() {
                    $icon.removeClass('ph-pause-circle').addClass('ph-play-circle');
                    $iconWrapper.removeClass('active');
                    currentAudio = null;
                    currentIcon = null;
                    currentWrapper = null;
                };
            });

            $('#addOrEditForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        ajaxBeforeSend('#addOrEditForm', '#formSubmitBtn');
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            let offcanvasElement = document.getElementById(
                                'addOrEditOffCanvas');
                            let offcanvasInstance = bootstrap.Offcanvas.getInstance(
                                offcanvasElement);
                            if (offcanvasInstance) {
                                offcanvasInstance.hide();
                            }

                            $('#addOrEditForm')[0].reset();
                            notify('success', response.message);
                        }
                    },
                    error: handleAjaxErrors,
                    complete: function() {
                        ajaxComplete('#formSubmitBtn');
                    }
                });
            });


            let questionOneData = {};
            let questionTwoData = {};
            let supervisorName = null;

            function sendSupervisorName() {


                $.ajax({
                    url: '{{ route('health-safety-review.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_date: '{{ $start_date ?? '' }}',
                        crew: '{{ $crew ?? '' }}',
                        shift: '{{ $shift ?? '' }}',
                        supervisor_name: supervisorName
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            notify('success', 'Supervisor name saved successfully.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error saving supervisor name:', xhr.responseText);
                    }
                });
            }


            // Common function to send data
            function sendReviewUpdate(date = null, supervisorName = null) {
                const q1 = questionOneData[date] ?? null;
                const q2 = questionTwoData[date] ?? null;

                // Skip if both are empty
                // if (!q1 && !q2) return;

                $.ajax({
                    url: '{{ route('health-safety-review.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_date: '{{ $start_date ?? '' }}',
                        crew: '{{ $crew ?? '' }}',
                        shift: '{{ $shift ?? '' }}',
                        date: date,
                        question_1: q1 ? {
                            [date]: q1
                        } : null,
                        question_2: q2 ? {
                            [date]: q2
                        } : null,
                        supervisor_name: supervisorName
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            notify('success', response.message);
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error saving for date:', date, xhr.responseText);
                    }
                });
            }
            // Handle supervisor name blur
            $(document).on('blur', '.supervisor-name', function() {
                supervisorName = $(this).text().trim();
                sendSupervisorName();
            });

            // Handle question-one blur
            $(document).on('blur', '.question-one', function() {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                questionOneData[date] = answer;
                sendReviewUpdate(date);
            });

            // Handle question-two blur
            $(document).on('blur', '.question-two', function() {
                let answer = $(this).text().trim();
                let date = $(this).data('date');
                questionTwoData[date] = answer;
                sendReviewUpdate(date);
            });
        });
    </script>
@endsection
@section('page-css')
    <style>
        .question-one,
        .question-two {
            padding: 2px;
        }

        .card-header {
            background-color: #0d0172;
            border-bottom: 1px solid #060041;
            color: #fff;
            padding: 0.8rem 1rem;
        }

        .card-title {
            font-size: 1.45rem;
            font-weight: 600;
        }

        .card-body {
            background-color: #00680e;
            padding: 1.5rem;
        }

        .board-container {
            background-color: #fff;
            border-radius: 6px;
            padding: 1rem;
        }

        .board {
            border: 2px solid #00680e;
            border-radius: 6px;
            padding: 1.5rem;
            background-color: #fff;
        }

        .board-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .header-logo {
            max-width: 90px;
        }

        .table>:not(caption)>*>* {
            padding: .45rem .5rem;
        }

        span.play-icon {
            background-color: #007bff;
            color: #fff;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-align: center;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        span.play-icon.active {
            background-color: #28a745;
            transform: scale(1.1);
        }

        span.play-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        i.ph {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .board-title {
                font-size: 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 0;
            }

            .btn-sm {
                width: 100%;
                margin-top: 0.5rem;
            }

            .board-header img {
                max-width: 70px;
            }
        }

        @media (max-width: 480px) {
            .card-body {
                padding: 0;
            }

            .board-header img {
                max-width: 50px;
            }

            .board-title {
                font-size: 0.9rem;
            }

            .board-container {
                border-radius: 3px;
                padding: 0.5rem;
            }
        }
    </style>
@endsection
