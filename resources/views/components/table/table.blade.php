@props([
    'id' => 'dataTable',
    'tableVariant' => 'table-sm table-hover table-striped align-middle table-nowrap mb-0',
    'thead' => null,
    'tbody' => null,
    'tfoot' => null,
])

<x-layouts.table-layout :id="$id" :tableVariant="$tableVariant">
    @if (is_array($thead))
        <thead>
            <tr>
                @foreach ($thead as $th)
                    @php
                        $label = is_array($th) ? $th['label'] ?? '' : $th;
                        $class = is_array($th) ? $th['class'] ?? '' : '';
                    @endphp
                    <th class="{{ $class }}">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
    @elseif(isset($thead))
        <thead>
            {{ $thead }}
        </thead>
    @endif

    {{ $slot }}

    @isset($tfoot)
        <tfoot>
            {{ $tfoot }}
        </tfoot>
    @endisset
</x-layouts.table-layout>
