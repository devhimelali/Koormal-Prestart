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
            <h4 class="card-title mb-0" id="board-title">Our Productivity</h4>
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
                            <h5 class="board-title mb-0">
                                Review of Previous Shift
                            </h5>
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
                                <h6>
                                    What did we do well to be more productive on our last shift?
                                </h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <tbody>
                                    @forelse ($reviewOfPreviousShiftsQuestionOne as $productive)
                                        <tr class="align-middle">
                                            <td class="bg-light td-date">
                                                <span>
                                                    {{ $productive->date }}
                                                    ({{ \Carbon\Carbon::parse($productive->date)->format('l') }})
                                                </span>
                                            </td>
                                            <td class="p-1 align-top w-auto">
                                                <div style="
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
                                                    {{ $productive->answer }}
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
                                    What did we do that was less productive on our last shift?
                                </h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <tbody>
                                    @forelse ($reviewOfPreviousShiftsQuestionTwo as $productive)
                                        <tr class="align-middle">
                                            <td class="bg-light td-date">
                                                <span>
                                                    {{ $productive->date }}
                                                    ({{ \Carbon\Carbon::parse($productive->date)->format('l') }})
                                                </span>
                                            </td>
                                            <td class="p-1 align-top w-auto">
                                                <div style="
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
                                                    {{ $productive->answer }}
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
