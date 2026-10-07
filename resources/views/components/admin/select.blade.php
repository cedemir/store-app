@props(['name', 'label', 'options' => [], 'value' => null, 'placeholder' => null])

@php($selected = (string) old($name, $value))

<div class="w-full mb-5">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->class(['form-input', 'form-input-error' => $errors->has($name)]) }}>
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected($selected === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
