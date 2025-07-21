@props([
    'id' => 'dataTable',
    'tableVariant' => 'table-sm table-hover table-striped align-middle table-nowrap mb-0',
])

<div class="table-responsive">
    <table id="{{ $id }}" class="table {{ $tableVariant }}">
        {{ $slot }}
    </table>
</div>
