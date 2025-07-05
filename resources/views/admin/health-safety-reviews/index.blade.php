@extends('layouts.app')
@section('title', 'Health Safety Review')
@section('content')
    <x-common.breadcrumb :title="'Our Health & Safety List'" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('redirect')], ['label' => 'Our Health & Safety List']]" />
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="card-title mb-0">Our Health & Safety</h4>
                </div>
                <div class="card-body">
                    <div class="board-container">
                        <div class="board">
                            <!-- Header with Logos and Title -->
                            <div class="row align-items-center board-header mb-3">
                                <div class="col-3 col-md-4 text-start text-md-center mb-2 mb-md-0">
                                    <img src="{{ asset('assets/logos/4emus-logo.png') }}"
                                        class="img-fluid header-logo float-start">
                                </div>
                                <div class="col-6 col-md-4 text-center">
                                    <h5 class="board-title mb-1">Review of Health & Safety</h5>
                                    <p class="text-muted small mb-0">Shift: {{ ucfirst(request('shift')) }}</p>
                                    <p class="text-muted small mb-0">Crew: {{ ucfirst(request('crew')) }}</p>
                                </div>
                                <div class="col-3 col-md-4 text-end text-md-center">
                                    <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                        class="img-fluid header-logo float-end">
                                </div>
                            </div>

                            <!-- Question 1 -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h6 class="mb-2 mb-md-0">Question 1 - What did we do to work more safely or improve our
                                    health on our last shift?</h6>
                                <button type="button" class="btn btn-sm btn-secondary d-flex align-items-center gap-1"
                                    data-bs-toggle="offcanvas" data-bs-target="#addOrEditOffCanvas"
                                    aria-controls="addOrEditOffCanvas">
                                    <i class="ph ph-plus"></i> Add
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead class="bg-light text-center">
                                        <tr style="vertical-align: middle;">
                                            <th style="max-width: 160px; width: 160px;">Day (Date)</th>
                                            <th>Answer</th>
                                            <th style="max-width: 180px; width: 180px;">Supervisor</th>
                                            <th style="max-width: 160px; width: 160px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($healthSafetyReviews as $data)
                                            <tr style="vertical-align: middle;">
                                                <td>{{ \Carbon\Carbon::parse($data->date)->format('l') }}
                                                    ({{ $data->date }})
                                                </td>
                                                <td>{{ $data->question_1 }}</td>
                                                <td>{{ $data->supervisor_name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary d-flex align-items-center gap-1"
                                                            data-id="{{ $data->id }}">
                                                            <i class="ph ph-pencil"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger d-flex align-items-center gap-1"
                                                            data-id="{{ $data->id }}">
                                                            <i class="ph ph-trash"></i>
                                                        </button>
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
                                <h6>Question 2 - What wasn’t as healthy or safe as it should have been on our last shift?
                                </h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead class="bg-light text-center">
                                        <tr style="vertical-align: middle;">
                                            <th style="max-width: 160px; width: 160px;">Day (Date)</th>
                                            <th>Answer</th>
                                            <th style="max-width: 180px; width: 180px;">Supervisor</th>
                                            <th style="max-width: 160px; width: 160px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($healthSafetyReviews as $data)
                                            <tr style="vertical-align: middle;">
                                                <td>{{ \Carbon\Carbon::parse($data->date)->format('l') }}
                                                    ({{ $data->date }})
                                                </td>
                                                <td>{{ $data->question_2 }}</td>
                                                <td>{{ $data->supervisor_name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-sm btn-secondary d-flex align-items-center gap-1"
                                                            data-id="{{ $data->id }}">
                                                            <i class="ph ph-pencil"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger d-flex align-items-center gap-1"
                                                            data-id="{{ $data->id }}">
                                                            <i class="ph ph-trash"></i>
                                                        </button>
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
        });
    </script>
@endsection
@section('page-css')
    <style>
        .card-header {
            background-color: #0d0172;
            border-bottom: 1px solid #060041;
            color: #fff;
            padding: 1.25rem 1rem;
        }

        .card-title {
            font-size: 1.75rem;
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
            font-size: 1.25rem;
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
