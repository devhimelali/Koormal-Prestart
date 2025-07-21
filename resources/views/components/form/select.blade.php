@props(['name', 'options' => [], 'value' => null, 'multiple' => false, 'placeholder' => 'Select an option'])

@php
    $id = $attributes->get('id') ?? Str::slug($name) . '-' . Str::uuid();
    $selected = old($name, $value);
@endphp

<select name="{{ $multiple ? $name . '[]' : $name }}" id="{{ $id }}" {{ $multiple ? 'multiple' : '' }}
    {{ $attributes->merge(['class' => 'form-select' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
    @if (!$multiple)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}"
            @if ($multiple && is_array($selected) && in_array($optionValue, $selected)) selected
                @elseif(!$multiple && $optionValue == $selected) selected @endif>
            {{ $optionLabel }}
        </option>
    @endforeach
</select>
