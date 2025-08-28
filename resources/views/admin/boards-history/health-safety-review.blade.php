<div class="card">
    <div class="card-body" style="background: #fff">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Supervisor Name :</h5>
                        <p class="text-muted mb-0 text-center">{{ $supervisor ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-auto bg-white p-3 border mb-3 rounded shadow-sm text-center" id="board-header">
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Date: </strong> {{ $start_date }} to
                    {{ $end_date }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Shift: </strong>
                    {{ ucfirst($shift_type) }}
                </p>
                <p class="mb-0 text-secondary" style="font-size: 16px;"><strong>Crew: </strong>{{ ucfirst($crew) }}
                </p>
            </div>
            <div class="col-md-4">
                <div class="card name-card border border-2 border-success mb-0 ms-auto">
                    <div class="name-card-body">
                        <h5 class="mb-1 text-center">Labour Name :</h5>
                        <p class="text-muted mb-0 text-center" id="labour-name">{{ $labour ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <style>
                .name-card-body {
                    padding: 0.5rem;
                    border-radius: 0% 0% 4px 4px;
                }
            </style>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card shadow">
        <div class="card-header text-center">
            <h4 class="card-title mb-0" id="board-title">Our Health & Safety</h4>
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
                            <h5 class="board-title mb-0">Review of Health & Safety</h5>
                        </div>
                        <div class="col-2 col-md-2 text-end text-md-center">
                            <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                 class="img-fluid header-logo float-end">
                        </div>
                    </div>
                    <div class="row my-4">
                        <!-- Question 1 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                <h6>Question 1 - What did we do to work more safely or improve
                                    our
                                    health on our last shift?
                                    <span class="play-icon"
                                          data-audio="{{ asset('assets/audios/our-health-safety/question-one.mp3') }}">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1phnduy"
                                             focusable="false"
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
                                    @forelse ($healthSafetyReviewsQuestionOne as $healthSafetyReview)
                                        <tr class="align-middle">
                                            <td class="bg-light td-date">
                                    <span>
                                        {{ $healthSafetyReview->date }}
                                        ({{ \Carbon\Carbon::parse($healthSafetyReview->date)->format('l') }})
                                    </span>
                                            </td>
                                            <td class="p-1 align-top w-auto">
                                                <div
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
                                                    {!! nl2br($healthSafetyReview->answer) !!}
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
                    <div class="row my-4">
                        <!-- Question 2 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                <h6>
                                    Question 2 - What wasn’t as healthy or safe as it should have been on our last
                                    shift?
                                    <span class="play-icon"
                                          data-audio="{{ asset('assets/audios/our-health-safety/question-two.mp3') }}">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1phnduy"
                                             focusable="false"
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
                                    @forelse ($healthSafetyReviewsQuestionTwo as $healthSafetyReview)
                                        <tr class="align-middle">
                                            <td class="bg-light td-date">
                                    <span>
                                        {{ $healthSafetyReview->date }}
                                        ({{ \Carbon\Carbon::parse($healthSafetyReview->date)->format('l') }})
                                    </span>
                                            </td>
                                            <td class="p-1 align-top w-auto">
                                                <div
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
                                                    {!! nl2br($healthSafetyReview->answer) !!}
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
</div>
