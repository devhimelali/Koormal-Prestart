<div class="row mb-2 align-items-center">
    <div class="col-md-1">
        <img src="{{ asset('storage/'.$fatalityRisk->image) }}" alt="hazard-control" width="40" class="img-fluid">
    </div>
    <div class="col-md-8">
        <h5 class="mb-0">
            {{ $fatalityRisk->name }}
        </h5>
    </div>
    <div class="col-md-3">
        <div class="btn-group float-end">
            <button class="btn btn-sm btn-secondary" data-fatality-risk-id="{{ $fatalityRisk->id }}"
                    data-shift-log-id="{{ $shiftLogId }}" id="addHazardControlBtn">
                <i class="bi bi-plus"></i>
                Add
            </button>
            <button class="btn btn-sm btn-success" data-fatality-risk-id="{{ $fatalityRisk->id }}"
                    data-shift-log-id="{{ $shiftLogId }}" id="viewFatalityControlsBtn">
                <i class="bi bi-shield-check"></i>
                Controls
            </button>
        </div>
    </div>
</div>
<x-table
    id="hazardControlListTable"
    tableVariant="table-sm table-hover table-striped align-middle mb-0"
    :thead="[
            [
                'label' => '#',
                'class' => 'th-sn',
            ],
            [
                'label' => 'Fatality Risk',
                'class' => 'th-name',
            ],
            [
                'label' => 'Control',
                'class' => 'th-description',
            ],
            [
                'label' => 'Actions',
                'class' => 'th-hazard-control-actions',
            ],
        ]">
    @forelse($hazardControls as $hazardControl)
        <tr>
            <td class="th-sn">
                {{ $loop->iteration }}
            </td>
            <td class="th-name">
                {{ $hazardControl->fatalityRisk?->name }}
            </td>
            <td class="th-description">
                {{ $hazardControl->description }}
            </td>
            <td class="th-actions">
                <button class="btn btn-sm btn-danger deleteHazardControlBtn" data-hazard-control-id="{{ $hazardControl->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center py-2">No hazard controls found</td>
        </tr>
    @endforelse
</x-table>
<style>
    th.th-hazard-control-actions{
        min-width: 70px !important;
        width: 70px;
    }
</style>
