@props([
    'for' => '',
    'text' => '',
    'class' => 'form-label',
    'required' => false,
])


<label for="{{ $for }}" class="{{ $class }}">
    {{ $text }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
