@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => '',
    'label' => null,
    'required' => false,
    'placeholder' => '',
    'class' => 'form-control',
])

@php
    $inputId = $id ?? $name;
    // For value, use passed value or old input value
    $inputValue = old($name, $value);
@endphp

<input type="{{ $type }}" name="{{ $name }}" id="{{ $inputId }}" value="{{ $inputValue }}"
       placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => $class . ($errors->has($name) ? ' is-invalid' : '')]) }}>
