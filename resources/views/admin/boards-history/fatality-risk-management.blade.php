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
            <h4 class="card-title mb-0" id="board-title">Fatality Risk Management (FRM) Job Risk Control Board</h4>
        </div>
        <div class="card-body">
            <div class="board-container">
            </div>
        </div>
    </div>
</div>
