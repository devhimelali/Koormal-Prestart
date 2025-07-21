@props(['name', 'value' => '#000000', 'required' => false])

@php
    $id = $attributes->get('id') ?? Str::slug($name) . '-' . Str::uuid();
    $colorValue = old($name, $value);
@endphp

<input type="color" name="{{ $name }}" id="{{ $id }}" value="{{ $colorValue }}"
    {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    {{ $required ? 'required' : '' }}>
