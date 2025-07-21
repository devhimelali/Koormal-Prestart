@props([
    'id' => 'exampleModal',
    'title' => 'Modal Title',
    'size' => '',
    'staticBackdrop' => false,
    'keyboard' => true,
    'fade' => true,
    'showCloseButton' => true,
    'scrollable' => false,
])

@php
    $modalClasses = 'modal';
    if ($fade) {
        $modalClasses .= ' fade';
    }
    $backdrop = $staticBackdrop ? 'static' : true;
    $scrollable = $scrollable ? ' modal-dialog-scrollable' : '';
@endphp


<div class="{{ $modalClasses }}" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true" data-bs-backdrop="{{ $backdrop }}" data-bs-keyboard="{{ $keyboard ? 'true' : 'false' }}">
    <div class="modal-dialog {{ $size }} {{ $scrollable }}">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light py-2">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>

                @if ($showCloseButton)
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                {{ $slot }}
            </div>

            <!-- Modal Footer (optional) -->
            @hasSection('footer')
                <div class="modal-footer">
                    @yield('footer')
                </div>
            @elseif(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
