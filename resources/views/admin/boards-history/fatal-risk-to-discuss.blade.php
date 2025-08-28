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
            <h4 class="card-title mb-0" id="board-title">Pick a Fatal Risk to discuss</h4>
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
                                Given our tasks this shift which Fatal Risk(s) are present? <br>
                                <span class="mt-2">
                                    (Circle and Discuss)
                                </span>
                            </h5>
                        </div>
                        <div class="col-2 col-md-2 text-end text-md-center">
                            <img src="{{ asset('assets/logos/koormal-logo.png') }}"
                                 class="img-fluid header-logo float-end">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row g-3">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="max-width: 120px; width: 120px">Date</th>
                                        <th style="max-width: 250px; width: 250px">Fatality Risk</th>
                                        <th>Control List</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($fatalRiskToDiscusses as $fatalRiskToDiscuss)
                                        <tr class="align-middle">
                                            <td class="text-center">{{$fatalRiskToDiscuss->date}}</td>
                                            <td>
                                                <div class="text-center">
                                                    <img src="{{asset('storage/'. $fatalRiskToDiscuss->fatalityRiskArchive->image)}}" width="50" height="50" alt="{{$fatalRiskToDiscuss->fatalityRiskArchive->name}}">
                                                    <h6 class="mb-0 mt-1" style="color: #575757;">
                                                        {{$fatalRiskToDiscuss->fatalityRiskArchive->name}}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="">
                                                    @forelse($fatalRiskToDiscuss->fatalRiskToDiscussControlArchives as $controlList)
                                                        <li>
                                                            {{$controlList->description}}
                                                        </li>
                                                    @empty
                                                        <li>No Control List</li>
                                                    @endforelse
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            No fatality risks available.
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
