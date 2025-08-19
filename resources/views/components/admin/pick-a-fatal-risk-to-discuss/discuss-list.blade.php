<x-table
    tableVariant="table-sm table-hover table-striped align-middle mb-0"
    :thead="[
            [
                'label' => '#',
                'class' => 'th-sn',
            ],
            [
                'label' => 'Fatality Risk',
                'class' => 'th-fatality-risk',
            ],
            [
                'label' => 'Controls',
                'class' => 'th-control',
            ],
            [
                'label' => 'Discuss Note',
                'class' => 'th-discuss-note',
            ],
        ]">
    @forelse($discusses as $discuss)
        <tr>
            <td>
                {{ $loop->iteration }}
            </td>
            <td>
                {{$discuss?->fatalityRisk?->name}}
            </td>
            <td>
                <ul>
                    @forelse($discuss->fatalToDiscussControls as $control)
                        <li>
                            {{$control?->description}}
                        </li>
                    @empty
                    @endforelse
                </ul>
            </td>
            <td>
                {{$discuss?->discuss_note}}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">
                No data available
            </td>
        </tr>
    @endforelse
</x-table>
<style>
    th.th-fatality-risk {
        max-width: 250px;
        width: 250px;
    }

    th.th-control {
        max-width: 400px;
        width: 400px;
    }
</style>
