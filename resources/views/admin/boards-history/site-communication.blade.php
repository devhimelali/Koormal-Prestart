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
            <h4 class="card-title mb-0" id="board-title">Site Communications</h4>
        </div>
        <div class="card-body">
            <div class="board-container">
                <div class="board">
                    <!-- Header with Logos and Title -->
                    <div class="row align-items-center board-header mb-3">
                        <div class="col-2 col-md-2 text-start text-md-center mb-2 mb-md-0">
                            <img src="{{ asset('assets/logos/4emus-logo.png') }}" class="img-fluid header-logo float-start">
                        </div>
                        <div class="col-8 col-md-8 text-center">
                            <h5 class="board-title mb-0">
                                Site Communication
                            </h5>
                        </div>
                        <div class="col-2 col-md-2 text-end text-md-center">
                            <img src="{{ asset('assets/logos/koormal-logo.png') }}" class="img-fluid header-logo float-end">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- Question 1 -->
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Crew</th>
                                        <th>Shift</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($siteCommunications as $siteCommunication)
                                        <tr class="align-middle">
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{$siteCommunication->title}}
                                            </td>
                                            <td>
                                                {{$siteCommunication->description}}
                                            </td>
                                            <td>
                                                {{$siteCommunication->shift}}
                                            </td>
                                            <td>
                                                {{$siteCommunication->shift_type === 'day' ? 'Day Shift' : 'Night Shift'}}
                                            </td>
                                            <td>
                                                {{\Carbon\Carbon::parse($siteCommunication->date)->format('d-m-Y')}}
                                            </td>
                                            <td style="width: 215px">
                                                <div class="btn-group">
                                                    <a href="{{asset('storage/'.$siteCommunication->path)}}" target="_blank" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-download"></i>
                                                        Download PDF
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No Site Communications</td>
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
