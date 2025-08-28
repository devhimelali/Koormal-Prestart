<div class="row mb-2 align-items-center">
    <div class="col-md-1">
        <img src="{{ asset('storage/'.$fatalityRisk->image) }}" alt="hazard-control" width="40" class="img-fluid">
    </div>
    <div class="col-md-8">
        <h5 class="mb-0">
            {{ $fatalityRisk->name }}
        </h5>
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
        ]">
    @forelse($controls as $hazardControl)
        <tr>
            <td class="th-sn">
                {{ $loop->iteration }}
            </td>
            <td class="th-name">
                {{ $hazardControl->fatalityRiskArchive?->name }}
            </td>
            <td class="th-description">
                {{ $hazardControl->description }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center py-2">No hazard controls found</td>
        </tr>
    @endforelse
</x-table>
<style>
    th.th-name{
        max-width: 260px !important;
        width: 260px;
    }
    th.th-sn{
        min-width: 40px !important;
        max-width: 40px !important;
        width: 40px;
    }
</style>
