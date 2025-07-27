@props([
    'action' => '',
    'method' => 'POST',
    'hasFile' => false,
    'class' => null,
    'id' => null,
])

@php
    $formMethod = strtoupper($method);
    $spoofMethod = in_array($formMethod, ['PUT', 'PATCH', 'DELETE']);
@endphp

<form action="{{ $action }}" method="{{ $spoofMethod ? 'POST' : $formMethod }}"
      @if ($hasFile) enctype="multipart/form-data" @endif
      @if ($class) class="{{ $class }}" @endif
      @if ($id) id="{{ $id }}" @endif>
    @csrf

    @if ($spoofMethod)
        @method($formMethod)
    @endif

    {{ $slot }}
    @if (isset($buttons))
        <div class="mt-3 d-flex justify-content-end gap-2 align-items-center">
            {{ $buttons }}
        </div>
    @endif
</form>
